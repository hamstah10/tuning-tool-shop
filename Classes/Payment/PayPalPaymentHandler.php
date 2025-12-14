<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PayPalPaymentHandler implements PaymentHandlerInterface
{
    protected array $config = [];

    public function __construct()
    {
        $this->loadConfiguration();
    }

    protected function loadConfiguration(): void
    {
        try {
            $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('transactor_paypal');
            $this->config = is_array($extConf) ? $extConf : [];
        } catch (\Exception $e) {
            $this->config = [];
        }
    }

    public function processPayment(Order $order): PaymentResult
    {
        $formAction = $this->getPayPalUrl();
        $fields = $this->buildPaymentFields($order);

        return PaymentResult::form($formAction, $fields);
    }

    public function getPaymentForm(Order $order): ?string
    {
        return null;
    }

    public function handleCallback(array $parameters): PaymentResult
    {
        // Verify IPN authenticity with PayPal
        if (!$this->verifyIpn($parameters)) {
            return PaymentResult::failed('IPN-Verifizierung fehlgeschlagen');
        }

        $paymentStatus = $parameters['payment_status'] ?? '';
        $txnId = $parameters['txn_id'] ?? '';

        if ($paymentStatus === 'Completed') {
            return PaymentResult::success($txnId, 'PayPal-Zahlung erfolgreich');
        }

        if ($paymentStatus === 'Pending') {
            return PaymentResult::pending('PayPal-Zahlung ausstehend');
        }

        // Declined, expired, failed, voided, refunded, etc.
        return PaymentResult::failed('PayPal-Zahlung fehlgeschlagen: ' . $paymentStatus);
    }

    protected function verifyIpn(array $parameters): bool
    {
        $verifyUrl = (bool)($this->config['sandbox'] ?? true) 
            ? 'https://www.sandbox.paypal.com/cgi-bin/webscr'
            : 'https://www.paypal.com/cgi-bin/webscr';

        // Build verification request
        $verifyData = 'cmd=_notify-validate';
        foreach ($parameters as $key => $value) {
            $verifyData .= '&' . urlencode($key) . '=' . urlencode($value);
        }

        // Send verification request to PayPal
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $verifyData,
                'timeout' => 10,
            ],
        ]);

        $response = @file_get_contents($verifyUrl, false, $context);

        return $response === 'VERIFIED';
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
        $this->config = array_merge($this->config, $config);
    }

    protected function getPayPalUrl(): string
    {
        $sandbox = (bool)($this->config['sandbox'] ?? true);

        if ($sandbox) {
            return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        return 'https://www.paypal.com/cgi-bin/webscr';
    }

    protected function buildPaymentFields(Order $order): array
    {
        $business = $this->config['business'] ?? '';
        $currency = $this->config['currency'] ?? 'EUR';

        $fields = [
            'cmd' => '_xclick',
            'business' => $business,
            'currency_code' => $currency,
            'charset' => 'UTF-8',
            'no_shipping' => '1',
            'no_note' => '1',
            'item_name' => 'Bestellung ' . $order->getOrderNumber(),
            'item_number' => $order->getOrderNumber(),
            'amount' => number_format($order->getTotalAmount(), 2, '.', ''),
            'invoice' => $order->getOrderNumber(),
            'custom' => (string)$order->getUid(),
        ];

        return $fields;
    }

    public function buildReturnUrls(int $successPid, int $cancelPid, int $notifyPid): array
    {
        $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        return [
            'return' => $baseUrl . '?id=' . $successPid,
            'cancel_return' => $baseUrl . '?id=' . $cancelPid,
            'notify_url' => $baseUrl . '?id=' . $notifyPid . '&type=1641916401',
        ];
    }
}
