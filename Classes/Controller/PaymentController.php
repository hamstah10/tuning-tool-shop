<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Payment\PaymentHandlerInterface;
use Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler;
use Hamstahstudio\TuningToolShop\Payment\KlarnaPaymentHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class PaymentController extends ActionController
{
    public function __construct(
        protected readonly OrderRepository $orderRepository,
        protected readonly CartItemRepository $cartItemRepository,
        protected readonly PersistenceManager $persistenceManager,
        protected readonly LoggerInterface $logger,
    ) {}

    public function redirectAction(Order $order): ResponseInterface
    {
        $this->logger->info('PaymentController::redirectAction called', [
            'orderId' => $order->getUid(),
            'orderNumber' => $order->getOrderNumber(),
        ]);

        $paymentMethod = $order->getPaymentMethod();

        if ($paymentMethod === null) {
            $this->logger->warning('No payment method found for order', ['orderId' => $order->getUid()]);
            $this->addFlashMessage('Keine Zahlungsart gewählt.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $handlerClass = $paymentMethod->getHandlerClass();
        $this->logger->info('Payment method found', [
            'handlerClass' => $handlerClass,
            'paymentMethodTitle' => $paymentMethod->getTitle(),
        ]);

        if (empty($handlerClass) || !class_exists($handlerClass)) {
            $this->logger->info('No payment handler needed, marking order as confirmed');
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
            $this->logger->info('Setting PayPal configuration');
            $handler->setConfiguration($this->settings['paypal']);
        }

        if ($handler instanceof KlarnaPaymentHandler && isset($this->settings['klarna'])) {
            $this->logger->info('Setting Klarna configuration');
            $handler->setConfiguration($this->settings['klarna']);
        }

        $result = $handler->processPayment($order);
        $this->logger->info('Payment handler result', [
            'hasForm' => $result->hasForm(),
            'requiresRedirect' => $result->requiresRedirect(),
            'isSuccess' => $result->isSuccess(),
        ]);

        if ($result->hasForm()) {
            $this->logger->info('Rendering payment form');
            $successPid = (int)($this->settings['payment']['successPid'] ?? ($this->settings['confirmationPid'] ?? $GLOBALS['TSFE']->id ?? 0));
            $cancelPid = (int)($this->settings['payment']['cancelPid'] ?? $GLOBALS['TSFE']->id ?? 0);
            $notifyPid = (int)($this->settings['payment']['notifyPid'] ?? $GLOBALS['TSFE']->id ?? 0);
            
            // Fallback: use current page if no PIDs configured
            if (!$successPid) $successPid = (int)($GLOBALS['TSFE']->id ?? 0);
            if (!$cancelPid) $cancelPid = (int)($GLOBALS['TSFE']->id ?? 0);
            if (!$notifyPid) $notifyPid = (int)($GLOBALS['TSFE']->id ?? 0);

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
            $this->logger->info('Redirecting to payment URL', ['url' => $result->getRedirectUrl()]);
            return $this->redirectToUri($result->getRedirectUrl());
        }

        if ($result->isSuccess()) {
            $this->logger->info('Payment successful, marking order as confirmed');
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $order->setStatus(Order::STATUS_CONFIRMED);
            $order->setTransactionId($result->getTransactionId());
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
        }

        $this->logger->error('Payment failed', ['message' => $result->getMessage()]);
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

        // Only show success message - do NOT mark as confirmed yet
        // The order status will be updated by IPN callback from PayPal
        // Show a pending message if payment is still pending
        if ($order->getPaymentStatus() === Order::PAYMENT_STATUS_PENDING) {
            $this->addFlashMessage(
                'Zahlung wird verarbeitet. Sie erhalten eine Bestätigungsemail, sobald die Zahlung bestätigt wurde.',
                'Zahlung ausstehend',
                \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::INFO
            );
        }

        // Clear cart items from session even if payment is pending
        $frontendUser = $this->request->getAttribute('frontend.user');
        if ($frontendUser !== null && isset($frontendUser->user)) {
            $sessionId = 'user_' . $frontendUser->user['uid'];
        } else {
            $sessionId = $_COOKIE['tx_tuning_tool_shop_session'] ?? '';
        }

        if (!empty($sessionId)) {
            // Remove cart items for this session
            $cartItems = $this->cartItemRepository->findBySessionId($sessionId);
            foreach ($cartItems as $cartItem) {
                $this->cartItemRepository->remove($cartItem);
            }
            $this->persistenceManager->persistAll();
        }

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
