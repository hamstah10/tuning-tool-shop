<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class KlarnaPaymentHandler implements PaymentHandlerInterface
{
    protected array $config = [];
    protected string $apiUrl = 'https://api.klarna.com';
    protected string $sandboxUrl = 'https://api.sandbox.klarna.com';
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
            $apiKey = $this->config['klarna']['apiKey'] ?? '';
            $merchantId = $this->config['klarna']['merchantId'] ?? '';
            $sandbox = (bool)($this->config['klarna']['sandbox'] ?? true);

            if (empty($apiKey) || empty($merchantId)) {
                return PaymentResult::failed('Klarna API-Schlüssel oder Merchant ID nicht konfiguriert');
            }

            $sessionId = $this->createSession($order, $apiKey, $sandbox);
            if (empty($sessionId)) {
                return PaymentResult::failed('Klarna Session konnte nicht erstellt werden');
            }

            // Store session ID for later verification
            $order->setTransactionId($sessionId);

            return PaymentResult::redirect($this->getAuthorizationUrl($sessionId, $sandbox));
        } catch (\Exception $e) {
            return PaymentResult::failed('Zahlungsverarbeitung fehlgeschlagen: ' . $e->getMessage());
        }
    }

    public function getPaymentForm(Order $order): ?string
    {
        return null;
    }

    public function handleCallback(array $parameters): PaymentResult
    {
        try {
            $authorizationToken = $parameters['authorization_token'] ?? '';
            if (empty($authorizationToken)) {
                return PaymentResult::failed('Autorisierungs-Token nicht gefunden');
            }

            $apiKey = $this->config['klarna']['apiKey'] ?? '';
            $sandbox = (bool)($this->config['klarna']['sandbox'] ?? true);

            if (empty($apiKey)) {
                return PaymentResult::failed('Klarna nicht konfiguriert');
            }

            $result = $this->createOrder($authorizationToken, $apiKey, $sandbox);

            if (!empty($result['order_id'])) {
                return PaymentResult::success(
                    $result['order_id'],
                    'Klarna-Zahlung erfolgreich'
                );
            }

            return PaymentResult::failed('Klarna-Bestellung konnte nicht erstellt werden');
        } catch (\Exception $e) {
            return PaymentResult::failed('Klarna-Fehler: ' . $e->getMessage());
        }
    }

    public function getDisplayName(): string
    {
        return 'Klarna';
    }

    public function requiresRedirect(): bool
    {
        return true;
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
     * Create a Klarna session
     */
    protected function createSession(Order $order, string $apiKey, bool $sandbox): string
    {
        $url = ($sandbox ? $this->sandboxUrl : $this->apiUrl) . '/payments/v1/sessions';

        $orderLines = [];
        $items = json_decode($order->getItemsJson() ?? '[]', true);

        foreach ($items as $item) {
            $orderLines[] = [
                'type' => 'physical',
                'name' => $item['productName'] ?? 'Product',
                'quantity' => $item['quantity'] ?? 1,
                'unit_price' => (int)round(($item['price'] ?? 0) * 100),
                'tax_rate' => 1900, // 19% VAT (German standard)
                'total_amount' => (int)round(($item['subtotal'] ?? 0) * 100),
                'total_tax_amount' => (int)round(($item['subtotal'] ?? 0) * 0.19 * 100),
            ];
        }

        // Add shipping costs
        if ($order->getShippingCost() > 0) {
            $orderLines[] = [
                'type' => 'shipping_fee',
                'name' => 'Versandkosten',
                'quantity' => 1,
                'unit_price' => (int)round($order->getShippingCost() * 100),
                'tax_rate' => 1900,
                'total_amount' => (int)round($order->getShippingCost() * 100),
                'total_tax_amount' => (int)round($order->getShippingCost() * 0.19 * 100),
            ];
        }

        $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        $payload = [
            'purchase_country' => substr($order->getBillingCountry(), 0, 2),
            'purchase_currency' => 'EUR',
            'locale' => 'de-DE',
            'amount' => (int)round($order->getTotalAmount() * 100),
            'tax_amount' => (int)round($order->getTotalAmount() * 0.19 * 100),
            'order_lines' => $orderLines,
            'billing_address' => [
                'given_name' => $order->getCustomerFirstName(),
                'family_name' => $order->getCustomerLastName(),
                'email' => $order->getCustomerEmail(),
                'street_address' => $order->getBillingStreet(),
                'postal_code' => $order->getBillingZip(),
                'city' => $order->getBillingCity(),
                'country' => $order->getBillingCountry(),
            ],
            'merchant_urls' => [
                'success' => $baseUrl . '?type=tx_tuningtoolshop_payment&tx_tuningtoolshop_payment[action]=success&tx_tuningtoolshop_payment[order]=' . $order->getUid(),
                'cancel' => $baseUrl . '?type=tx_tuningtoolshop_payment&tx_tuningtoolshop_payment[action]=cancel',
                'failure' => $baseUrl . '?type=tx_tuningtoolshop_payment&tx_tuningtoolshop_payment[action]=cancel',
                'notification' => $baseUrl . '?type=tx_tuningtoolshop_payment&tx_tuningtoolshop_payment[action]=notify',
            ],
        ];

        $response = $this->apiRequest('POST', $url, $payload, $apiKey);

        return $response['session_id'] ?? '';
    }

    /**
     * Create order from authorization token
     */
    protected function createOrder(string $authorizationToken, string $apiKey, bool $sandbox): array
    {
        $url = ($sandbox ? $this->sandboxUrl : $this->apiUrl) . '/payments/v1/authorizations/' . $authorizationToken . '/orders';

        return $this->apiRequest('POST', $url, [], $apiKey);
    }

    /**
     * Get Klarna checkout URL
     */
    protected function getAuthorizationUrl(string $sessionId, bool $sandbox): string
    {
        $baseUrl = $sandbox
            ? 'https://checkout.sandbox.klarna.com'
            : 'https://checkout.klarna.com';

        return $baseUrl . '/checkout/payments/' . $sessionId;
    }

    /**
     * Make API request to Klarna
     */
    protected function apiRequest(string $method, string $url, array $payload, string $apiKey): array
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $apiKey . ':',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_TIMEOUT => 30,
        ];

        if (!empty($payload)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($payload);
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Klarna API-Anfrage fehlgeschlagen');
        }

        $data = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMsg = $data['error_messages'][0] ?? 'Unknown error';
            throw new \Exception('Klarna API Error: ' . $errorMsg);
        }

        return $data ?? [];
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $orderId): ?array
    {
        try {
            $apiKey = $this->config['klarna']['apiKey'] ?? '';
            $sandbox = (bool)($this->config['klarna']['sandbox'] ?? true);

            if (empty($apiKey)) {
                return null;
            }

            $url = ($sandbox ? $this->sandboxUrl : $this->apiUrl) . '/ordermanagement/v1/orders/' . $orderId;
            $result = $this->apiRequest('GET', $url, [], $apiKey);

            return [
                'order_id' => $result['order_id'] ?? $orderId,
                'status' => $result['status'] ?? 'unknown',
                'amount' => ($result['order_amount'] ?? 0) / 100,
                'currency' => $result['purchase_currency'] ?? 'EUR',
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $orderId, ?float $amount = null): PaymentResult
    {
        try {
            $apiKey = $this->config['klarna']['apiKey'] ?? '';
            $sandbox = (bool)($this->config['klarna']['sandbox'] ?? true);

            if (empty($apiKey)) {
                return PaymentResult::failed('Klarna nicht konfiguriert');
            }

            $url = ($sandbox ? $this->sandboxUrl : $this->apiUrl) . '/ordermanagement/v1/orders/' . $orderId . '/refunds';

            $payload = [];
            if ($amount !== null) {
                $payload['refunded_amount'] = (int)round($amount * 100);
            }

            $result = $this->apiRequest('POST', $url, $payload, $apiKey);

            if (!empty($result['refund_id'])) {
                return PaymentResult::success(
                    $result['refund_id'],
                    'Klarna Rückerstattung erfolgreich'
                );
            }

            return PaymentResult::failed('Klarna Rückerstattung fehlgeschlagen');
        } catch (\Exception $e) {
            return PaymentResult::failed('Klarna-Fehler: ' . $e->getMessage());
        }
    }
}
