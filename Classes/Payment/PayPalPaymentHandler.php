<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Service\PayPalService;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

class PayPalPaymentHandler implements PaymentHandlerInterface
{
    private string $returnUrl = '';

    public function __construct(
        private readonly PayPalService $payPalService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function processPayment(Order $order): PaymentResult
    {
        $this->logger->info('[PayPal] === PAYPAL PAYMENT HANDLER START ===', [
            'orderId' => $order->getUid(),
            'orderNumber' => $order->getOrderNumber(),
            'totalAmount' => $order->getTotalAmount(),
        ]);

        try {
            $this->logger->info('[PayPal] Getting PayPal settings');
            $settings = $this->payPalService->getSettings();
            
            $this->logger->info('[PayPal] Settings loaded', [
                'mode' => $settings['payPalMode'] ?? 'unknown',
                'hasClientId' => !empty($settings['payPalSandboxClientId'] ?? $settings['payPalLiveClientId'] ?? null),
            ]);
            
            $redirectUrl = !empty($this->returnUrl) ? $this->returnUrl : '/';
            
            $this->logger->info('[PayPal] Return URL set', ['url' => $redirectUrl]);
            
            $this->logger->info('[PayPal] Calling PayPalService->createPayment()');
            $checkoutUrl = $this->payPalService->createPayment(
                'Order ' . $order->getOrderNumber(),
                $order->getTotalAmount(),
                $redirectUrl
            );
            
            $this->logger->info('[PayPal] PayPalService returned', [
                'hasCheckoutUrl' => !empty($checkoutUrl),
                'urlLength' => strlen($checkoutUrl ?? ''),
                'urlPreview' => $checkoutUrl ? substr($checkoutUrl, 0, 100) : 'NULL',
            ]);
            
            if (!empty($checkoutUrl)) {
                $this->logger->info('[PayPal] === PAYPAL PAYMENT HANDLER SUCCESS ===', [
                    'redirectUrl' => substr($checkoutUrl, 0, 150),
                ]);
                return PaymentResult::redirect($checkoutUrl);
            }
            
            $this->logger->error('[PayPal] === PAYPAL PAYMENT HANDLER FAILED ===', [
                'reason' => 'Empty checkout URL returned from PayPalService',
                'orderId' => $order->getUid(),
                'orderNumber' => $order->getOrderNumber(),
            ]);
            return PaymentResult::failed('PayPal checkout URL could not be generated');
        } catch (\Exception $e) {
            $this->logger->error('[PayPal] === PAYPAL PAYMENT HANDLER EXCEPTION ===', [
                'error' => $e->getMessage(),
                'orderId' => $order->getUid(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return PaymentResult::failed('An error occurred during PayPal payment processing: ' . $e->getMessage());
        }
    }

    public function getPaymentForm(Order $order): ?string
    {
        return null;
    }

    public function handleCallback(array $parameters): PaymentResult
    {
        // Callback handling is managed by paypal-api extension via PaymentReturn page
        return PaymentResult::pending('PayPal payment callback handled');
    }

    public function getDisplayName(): string
    {
        return 'PayPal';
    }

    public function requiresRedirect(): bool
    {
        return true;
    }

    public function setConfiguration(array $config): void
    {
        // Configuration is handled by PayPalService from paypal-api extension
        // via TYPO3 ExtensionConfiguration, no action needed here
    }

    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }
}
