<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Payment\PaymentHandlerInterface;
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
        $this->logger->info('=== CHECKOUT PAYMENT START ===', [
            'orderId' => $order->getUid(),
            'orderNumber' => $order->getOrderNumber(),
            'totalAmount' => $order->getTotalAmount(),
            'timestamp' => date('Y-m-d H:i:s'),
        ]);

        $paymentMethod = $order->getPaymentMethod();

        if ($paymentMethod === null) {
            $this->logger->error('CHECKOUT: No payment method found', [
                'orderId' => $order->getUid(),
            ]);
            $this->addFlashMessage('Keine Zahlungsart gewählt.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $handlerClass = $paymentMethod->getHandlerClass();
        $this->logger->info('CHECKOUT: Payment method found', [
            'handlerClass' => $handlerClass,
            'paymentMethodTitle' => $paymentMethod->getTitle(),
        ]);

        if (empty($handlerClass) || !class_exists($handlerClass)) {
            $this->logger->info('CHECKOUT: No handler needed, marking as paid');
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $order->setStatus(Order::STATUS_CONFIRMED);
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
        }

        // Get handler instance with dependency injection
        /** @var PaymentHandlerInterface $handler */
        try {
            $handler = GeneralUtility::makeInstance($handlerClass);
            $this->logger->info('CHECKOUT: Handler instantiated', ['class' => $handlerClass]);
        } catch (\Exception $e) {
            $this->logger->error('CHECKOUT: Failed to instantiate handler', [
                'class' => $handlerClass,
                'error' => $e->getMessage(),
            ]);
            $this->addFlashMessage('Zahlungsmodul konnte nicht geladen werden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        // Pass payment provider settings to handler if applicable
        if ($handler instanceof KlarnaPaymentHandler && isset($this->settings['klarna'])) {
            $this->logger->info('CHECKOUT: Setting Klarna configuration');
            $handler->setConfiguration($this->settings['klarna']);
        }

        $this->logger->info('CHECKOUT: Calling handler->processPayment()');
        try {
            $result = $handler->processPayment($order);
        } catch (\Exception $e) {
            $this->logger->error('CHECKOUT: Handler threw exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->addFlashMessage('Fehler beim Zahlungsabwickeln.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $this->logger->info('CHECKOUT: Handler result', [
            'hasForm' => $result->hasForm(),
            'requiresRedirect' => $result->requiresRedirect(),
            'isSuccess' => $result->isSuccess(),
            'redirectUrl' => $result->getRedirectUrl() ? substr($result->getRedirectUrl(), 0, 100) : null,
        ]);

        if ($result->hasForm()) {
            $this->logger->info('CHECKOUT: Rendering payment form', [
                'formAction' => $result->getFormAction(),
            ]);
            $this->view->assignMultiple([
                'order' => $order,
                'formAction' => $result->getFormAction(),
                'formFields' => $result->getFormFields(),
                'paymentMethod' => $paymentMethod,
            ]);

            return $this->htmlResponse();
        }

        if ($result->requiresRedirect() && $result->getRedirectUrl()) {
            $this->logger->info('CHECKOUT: Redirecting to payment provider', [
                'url' => substr($result->getRedirectUrl(), 0, 150),
            ]);
            return $this->redirectToUri($result->getRedirectUrl());
        }

        if ($result->isSuccess()) {
            $this->logger->info('CHECKOUT: Payment immediate success, marking as paid');
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $order->setStatus(Order::STATUS_CONFIRMED);
            $order->setTransactionId($result->getTransactionId());
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
        }

        $message = $result->getMessage() ?? 'Unbekannter Fehler';
        $this->logger->error('CHECKOUT: Payment failed', ['message' => $message]);
        $this->addFlashMessage($message, 'Zahlungsfehler', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
        return $this->redirect('index', 'Checkout');
    }

    public function successAction(): ResponseInterface
    {
        $queryParams = $this->request->getQueryParams();
        $orderUid = (int)($queryParams['custom'] ?? $queryParams['order'] ?? 0);

        if ($orderUid === 0) {
            $orderUid = (int)($queryParams['tx_tuningtoolshop_payment']['order'] ?? 0);
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
