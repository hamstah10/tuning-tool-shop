<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Payment\StripePaymentHandler;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class StripeController extends ActionController
{
    public function __construct(
        protected readonly OrderRepository $orderRepository,
        protected readonly PersistenceManager $persistenceManager,
    ) {}

    /**
     * Create Payment Intent and return client secret
     */
    public function createPaymentIntentAction(): ResponseInterface
    {
        try {
            if (!$this->request->hasArgument('order')) {
                return $this->createJsonResponse(['error' => 'Order erforderlich'], 400);
            }

            $orderId = (int)$this->request->getArgument('order');
            $order = $this->orderRepository->findByUid($orderId);

            if ($order === null) {
                return $this->createJsonResponse(['error' => 'Bestellung nicht gefunden'], 404);
            }

            $handler = new StripePaymentHandler();
            $result = $handler->processPayment($order);

            if (!$result->isSuccess()) {
                return $this->createJsonResponse(['error' => $result->getMessage()], 400);
            }

            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();

            return $this->createJsonResponse([
                'success' => true,
                'paymentIntentId' => $result->getTransactionId(),
                'orderId' => $order->getUid(),
            ]);
        } catch (\Exception $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function successAction(): ResponseInterface
    {
        try {
            if (!$this->request->hasArgument('payment_intent')) {
                throw new \InvalidArgumentException('Payment Intent erforderlich');
            }

            $paymentIntentId = (string)$this->request->getArgument('payment_intent');
            $handler = new StripePaymentHandler();
            $result = $handler->handleCallback(['payment_intent' => $paymentIntentId]);

            if ($result->isSuccess()) {
                $order = $this->orderRepository->findOneByTransactionId($paymentIntentId);

                if ($order !== null) {
                    $order->setStatus(Order::STATUS_CONFIRMED);
                    $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
                    $this->orderRepository->update($order);
                    $this->persistenceManager->persistAll();

                    return $this->redirect('confirmation', 'Checkout', null, ['order' => $order->getUid()]);
                }
            }

            throw new \RuntimeException('Zahlungsbestätigung fehlgeschlagen');
        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Zahlungsverarbeitung fehlgeschlagen: ' . $e->getMessage(),
                '',
                \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR
            );
            return $this->redirect('index', 'Checkout');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancelAction(): ResponseInterface
    {
        $this->addFlashMessage(
            'Zahlung wurde abgebrochen.',
            '',
            \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING
        );

        return $this->redirect('index', 'Checkout');
    }

    /**
     * Handle Stripe webhook events
     */
    public function webhookAction(): ResponseInterface
    {
        try {
            $body = file_get_contents('php://input');
            $payload = json_decode($body, true);

            if (!is_array($payload)) {
                return $this->createJsonResponse(['error' => 'Invalid payload'], 400);
            }

            $webhookSecret = $this->settings['stripe']['webhookSecret'] ?? '';
            if (empty($webhookSecret)) {
                return $this->createJsonResponse(['error' => 'Webhook nicht konfiguriert'], 500);
            }

            // Verify webhook signature
            $sigHeader = $this->request->getHeader('Stripe-Signature')[0] ?? '';
            if (!$this->verifyWebhookSignature($body, $sigHeader, $webhookSecret)) {
                return $this->createJsonResponse(['error' => 'Ungültige Signatur'], 401);
            }

            $eventType = $payload['type'] ?? '';

            if ($eventType === 'payment_intent.succeeded') {
                $this->handlePaymentSucceeded($payload['data']['object'] ?? []);
            } elseif ($eventType === 'payment_intent.payment_failed') {
                $this->handlePaymentFailed($payload['data']['object'] ?? []);
            }

            return $this->createJsonResponse(['received' => true]);
        } catch (\Exception $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    private function handlePaymentSucceeded(array $paymentIntentData): void
    {
        $paymentIntentId = $paymentIntentData['id'] ?? '';
        if (empty($paymentIntentId)) {
            return;
        }

        $order = $this->orderRepository->findOneByTransactionId($paymentIntentId);
        if ($order !== null) {
            $order->setStatus(Order::STATUS_CONFIRMED);
            $order->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();
        }
    }

    private function handlePaymentFailed(array $paymentIntentData): void
    {
        $paymentIntentId = $paymentIntentData['id'] ?? '';
        if (empty($paymentIntentId)) {
            return;
        }

        $order = $this->orderRepository->findOneByTransactionId($paymentIntentId);
        if ($order !== null) {
            $order->setStatus(Order::STATUS_CANCELLED);
            $order->setPaymentStatus(Order::PAYMENT_STATUS_FAILED);
            $this->orderRepository->update($order);
            $this->persistenceManager->persistAll();
        }
    }

    private function verifyWebhookSignature(string $body, string $sigHeader, string $secret): bool
    {
        try {
            \Stripe\Webhook::constructEvent($body, $sigHeader, $secret);
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    private function createJsonResponse(array $data, int $statusCode = 200): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($statusCode)
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
