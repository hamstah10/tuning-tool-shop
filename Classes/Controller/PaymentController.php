<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Payment\PaymentHandlerInterface;
use Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler;
use Hamstahstudio\TuningToolShop\Payment\KlarnaPaymentHandler;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class PaymentController extends ActionController
{
    public function __construct(
        protected readonly OrderRepository $orderRepository,
        protected readonly PersistenceManager $persistenceManager,
    ) {}

    public function redirectAction(Order $order): ResponseInterface
    {
        $paymentMethod = $order->getPaymentMethod();

        if ($paymentMethod === null) {
            $this->addFlashMessage('Keine Zahlungsart gewählt.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $handlerClass = $paymentMethod->getHandlerClass();

        if (empty($handlerClass) || !class_exists($handlerClass)) {
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $order->setStatus(Order::STATUS_CONFIRMED);
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
        }

        /** @var PaymentHandlerInterface $handler */
        $handler = GeneralUtility::makeInstance($handlerClass);

        // Pass payment provider settings to handler if applicable
        if ($handler instanceof PayPalPaymentHandler && isset($this->settings['paypal'])) {
            $handler->setConfiguration($this->settings['paypal']);
        }

        if ($handler instanceof KlarnaPaymentHandler && isset($this->settings['klarna'])) {
            $handler->setConfiguration($this->settings['klarna']);
        }

        $result = $handler->processPayment($order);

        if ($result->hasForm()) {
            $successPid = (int)($this->settings['payment']['successPid'] ?? $GLOBALS['TSFE']->id);
            $cancelPid = (int)($this->settings['payment']['cancelPid'] ?? $GLOBALS['TSFE']->id);
            $notifyPid = (int)($this->settings['payment']['notifyPid'] ?? $GLOBALS['TSFE']->id);

            $formFields = $result->getFormFields();

            if ($handler instanceof PayPalPaymentHandler) {
                $urls = $handler->buildReturnUrls($successPid, $cancelPid, $notifyPid);
                $formFields = array_merge($formFields, $urls);
            }

            $this->view->assignMultiple([
                'order' => $order,
                'formAction' => $result->getFormAction(),
                'formFields' => $formFields,
                'paymentMethod' => $paymentMethod,
            ]);

            return $this->htmlResponse();
        }

        if ($result->requiresRedirect() && $result->getRedirectUrl()) {
            return $this->redirectToUri($result->getRedirectUrl());
        }

        if ($result->isSuccess()) {
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $order->setStatus(Order::STATUS_CONFIRMED);
            $order->setTransactionId($result->getTransactionId());
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
        }

        $this->addFlashMessage($result->getMessage(), 'Zahlungsfehler', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
        return $this->redirect('index', 'Checkout');
    }

    public function successAction(): ResponseInterface
    {
        $orderUid = (int)($this->request->getQueryParams()['custom'] ?? 0);

        if ($orderUid === 0) {
            $orderUid = (int)($this->request->getQueryParams()['tx_tuningtoolshop_payment']['order'] ?? 0);
        }

        $order = $this->orderRepository->findByUid($orderUid);

        if ($order === null) {
            $this->addFlashMessage('Bestellung nicht gefunden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Cart');
        }

        $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
        $order->setStatus(Order::STATUS_CONFIRMED);
        $this->orderRepository->update($order);
        $this->persistenceManager->persistAll();

        return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
    }

    public function cancelAction(): ResponseInterface
    {
        $this->addFlashMessage('Die Zahlung wurde abgebrochen.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        return $this->redirect('index', 'Cart');
    }

    public function notifyAction(): ResponseInterface
    {
        $params = $this->request->getParsedBody() ?? [];

        $orderUid = (int)($params['custom'] ?? 0);
        $order = $this->orderRepository->findByUid($orderUid);

        if ($order !== null) {
            $paymentMethod = $order->getPaymentMethod();

            if ($paymentMethod !== null) {
                $handlerClass = $paymentMethod->getHandlerClass();

                if (!empty($handlerClass) && class_exists($handlerClass)) {
                    /** @var PaymentHandlerInterface $handler */
                    $handler = GeneralUtility::makeInstance($handlerClass);
                    $result = $handler->handleCallback($params);

                    if ($result->isSuccess()) {
                        $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
                        $order->setStatus(Order::STATUS_CONFIRMED);
                        $order->setTransactionId($result->getTransactionId());
                    } elseif ($result->isPending()) {
                        $order->setPaymentStatus(Order::PAYMENT_STATUS_PENDING);
                    } else {
                        $order->setPaymentStatus(Order::PAYMENT_STATUS_FAILED);
                    }

                    $this->orderRepository->update($order);
                    $this->persistenceManager->persistAll();
                }
            }
        }

        return $this->htmlResponse('OK');
    }
}
