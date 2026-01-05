<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class StripePaymentHandler implements PaymentHandlerInterface
{
    protected array $config = [];
    protected string $returnUrl = '';

    public function __construct()
    {
        $this->loadConfiguration();
    }

    protected function loadConfiguration(): void
    {
        try {
            $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('tuning_tool_shop');
            $this->config = is_array($extConf) ? $extConf : [];
        } catch (\Exception $e) {
            $this->config = [];
        }
    }

    public function processPayment(Order $order): PaymentResult
    {
        try {
            $apiKey = $this->config['stripe']['apiKey'] ?? '';
            if (empty($apiKey)) {
                return PaymentResult::failed('Stripe API-Schlüssel nicht konfiguriert');
            }

            Stripe::setApiKey($apiKey);

            $amount = (int)round($order->getTotal() * 100);

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'description' => 'Bestellung #' . $order->getOrderNumber(),
                'metadata' => [
                    'order_id' => $order->getUid(),
                    'order_number' => $order->getOrderNumber(),
                    'customer_email' => $order->getCustomerEmail(),
                ],
                'receipt_email' => $order->getCustomerEmail(),
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            // Store transaction ID for later verification
            $order->setTransactionId($paymentIntent->id);

            return PaymentResult::success(
                $paymentIntent->id,
                'Stripe Payment Intent erstellt'
            );
        } catch (ApiErrorException $e) {
            return PaymentResult::failed('Stripe-Fehler: ' . $e->getMessage());
        } catch (\Exception $e) {
            return PaymentResult::failed('Zahlungsverarbeitung fehlgeschlagen: ' . $e->getMessage());
        }
    }

    public function getPaymentForm(Order $order): ?string
    {
        // Return null - Stripe.js wird direkt im Frontend verwendet
        return null;
    }

    public function handleCallback(array $parameters): PaymentResult
    {
        try {
            $paymentIntentId = $parameters['payment_intent'] ?? '';
            if (empty($paymentIntentId)) {
                return PaymentResult::failed('Zahlungs-ID nicht gefunden');
            }

            $apiKey = $this->config['stripe']['apiKey'] ?? '';
            if (empty($apiKey)) {
                return PaymentResult::failed('Stripe nicht konfiguriert');
            }

            Stripe::setApiKey($apiKey);
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                return PaymentResult::success(
                    $paymentIntent->id,
                    'Zahlung erfolgreich'
                );
            }

            if ($paymentIntent->status === 'processing') {
                return PaymentResult::pending('Zahlung wird verarbeitet');
            }

            return PaymentResult::failed('Zahlungsstatus: ' . $paymentIntent->status);
        } catch (ApiErrorException $e) {
            return PaymentResult::failed('Stripe-Fehler: ' . $e->getMessage());
        }
    }

    public function getDisplayName(): string
    {
        return 'Stripe';
    }

    public function requiresRedirect(): bool
    {
        return false;
    }

    public function setConfiguration(array $config): void
    {
        $this->config = array_merge($this->config, $config);
    }

    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $paymentIntentId, ?float $amount = null): PaymentResult
    {
        try {
            $apiKey = $this->config['stripe']['apiKey'] ?? '';
            if (empty($apiKey)) {
                return PaymentResult::failed('Stripe nicht konfiguriert');
            }

            Stripe::setApiKey($apiKey);

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if (empty($paymentIntent->charges->data)) {
                return PaymentResult::failed('Keine Zahlungen gefunden');
            }

            $chargeId = $paymentIntent->charges->data[0]->id;

            $refundParams = ['charge' => $chargeId];
            if ($amount !== null) {
                $refundParams['amount'] = (int)round($amount * 100);
            }

            $refund = \Stripe\Refund::create($refundParams);

            if ($refund->status === 'succeeded') {
                return PaymentResult::success(
                    $refund->id,
                    'Rückerstattung erfolgreich'
                );
            }

            return PaymentResult::failed('Rückerstattung fehlgeschlagen');
        } catch (ApiErrorException $e) {
            return PaymentResult::failed('Stripe-Fehler: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $paymentIntentId): ?array
    {
        try {
            $apiKey = $this->config['stripe']['apiKey'] ?? '';
            if (empty($apiKey)) {
                return null;
            }

            Stripe::setApiKey($apiKey);
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            return [
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'charge_id' => $paymentIntent->charges->data[0]->id ?? null,
            ];
        } catch (ApiErrorException $e) {
            return null;
        }
    }
}
