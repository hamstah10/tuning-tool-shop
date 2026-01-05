<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class PayPalService
{
    private string $payPalMode;
    private string $payPalUrl;
    private string $payPalClientId;
    private string $payPalClientSecret;
    private ?string $payPalAccessToken = null;
    private array $extConf;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {
        $this->extConf = $this->extensionConfiguration->get('tuning_tool_shop');
        $this->payPalMode = $this->extConf['payPalMode'] ?? 'sandbox';
        $this->payPalUrl = $this->payPalMode === 'live'
            ? 'https://api.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
        $this->payPalClientSecret = $this->payPalMode === 'live'
            ? ($this->extConf['payPalLiveClientSecret'] ?? '')
            : ($this->extConf['payPalSandboxClientSecret'] ?? '');
        $this->payPalClientId = $this->payPalMode === 'live'
            ? ($this->extConf['payPalLiveClientId'] ?? '')
            : ($this->extConf['payPalSandboxClientId'] ?? '');
    }

    public function getSettings(): array
    {
        return $this->extConf;
    }

    private function getAccessToken(): ?string
    {
        if ($this->payPalAccessToken !== null) {
            $this->logger->info('[PayPal] Using cached access token');
            return $this->payPalAccessToken;
        }

        $tokenUrl = $this->payPalUrl . '/v1/oauth2/token';
        $this->logger->info('[PayPal] Requesting access token', [
            'url' => $tokenUrl,
            'mode' => $this->payPalMode,
            'clientId' => substr($this->payPalClientId, 0, 10) . '...',
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_USERPWD, $this->payPalClientId . ':' . $this->payPalClientSecret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_errno($ch);

        if ($curlError) {
            $errorMsg = curl_error($ch);
            $this->logger->error('[PayPal] OAuth cURL error', [
                'curlError' => $curlError,
                'curlMessage' => $errorMsg,
            ]);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $this->logger->info('[PayPal] OAuth response received', [
            'httpCode' => $httpCode,
            'responseLength' => strlen((string)$result),
        ]);

        $response = json_decode((string)$result);
        if ($response === null) {
            $this->logger->error('[PayPal] OAuth response is not valid JSON', [
                'httpCode' => $httpCode,
                'response' => substr((string)$result, 0, 300),
            ]);
            return null;
        }

        if (!isset($response->access_token)) {
            $this->logger->error('[PayPal] OAuth response missing access_token', [
                'httpCode' => $httpCode,
                'error' => $response->error ?? 'unknown',
                'error_description' => $response->error_description ?? null,
                'fullResponse' => json_encode($response),
            ]);
            return null;
        }

        $this->logger->info('[PayPal] Access token obtained successfully');
        $this->payPalAccessToken = $response->access_token;
        return $this->payPalAccessToken;
    }

    public function createPayment(string $buyer, float $price, string $redirectUrl): string
    {
        $this->logger->info('[PayPal] === CREATE PAYMENT START ===', [
            'buyer' => $buyer,
            'price' => $price,
            'mode' => $this->payPalMode,
            'redirectUrl' => $redirectUrl,
        ]);
        
        $this->logger->info('[PayPal] Getting access token for payment');
        $accessToken = $this->getAccessToken();
        if ($accessToken === null) {
            $this->logger->error('[PayPal] === CREATE PAYMENT FAILED ===', [
                'reason' => 'Could not obtain access token',
            ]);
            return '';
        }

        $separator = strpos($redirectUrl, '?') !== false ? '&' : '?';
        $orderDetails = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => number_format($price, 2, '.', ''),
                    ],
                    'description' => $buyer,
                ],
            ],
            'return_url' => $redirectUrl . $separator . 'success=true',
            'cancel_url' => $redirectUrl . $separator . 'success=false',
        ];

        $this->logger->info('[PayPal] Order payload prepared', [
            'amount' => $orderDetails['purchase_units'][0]['amount']['value'],
            'description' => $orderDetails['purchase_units'][0]['description'],
            'returnUrl' => substr($orderDetails['return_url'], 0, 100),
        ]);

        try {
            $orderUrl = $this->payPalUrl . '/v2/checkout/orders';
            $this->logger->info('[PayPal] Sending order creation request', [
                'url' => $orderUrl,
                'method' => 'POST',
                'payloadSize' => strlen(json_encode($orderDetails)),
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $orderUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderDetails));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ]);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_errno($ch);

            if ($curlError) {
                $errorMsg = curl_error($ch);
                $this->logger->error('[PayPal] Order creation cURL error', [
                    'curlError' => $curlError,
                    'curlMessage' => $errorMsg,
                ]);
                curl_close($ch);
                return '';
            }

            curl_close($ch);

            $this->logger->info('[PayPal] Order creation response received', [
                'httpCode' => $httpCode,
                'responseLength' => strlen((string)$result),
            ]);

            $orderResponse = json_decode((string)$result, true);

            if ($httpCode !== 201) {
                $this->logger->error('[PayPal] Order creation returned non-201 status', [
                    'httpCode' => $httpCode,
                    'name' => $orderResponse['name'] ?? 'unknown',
                    'message' => $orderResponse['message'] ?? 'unknown',
                    'details' => $orderResponse['details'] ?? [],
                    'fullResponse' => json_encode($orderResponse),
                ]);
                return '';
            }

            $this->logger->info('[PayPal] Order created successfully (201)', [
                'orderId' => $orderResponse['id'] ?? 'unknown',
                'status' => $orderResponse['status'] ?? 'unknown',
                'linksCount' => count($orderResponse['links'] ?? []),
            ]);

            if (!isset($orderResponse['links']) || !is_array($orderResponse['links'])) {
                $this->logger->error('[PayPal] No links in order response', [
                    'response' => json_encode($orderResponse),
                ]);
                return '';
            }

            // Find the approve link
            $this->logger->info('[PayPal] Searching for approve link', [
                'totalLinks' => count($orderResponse['links']),
            ]);

            foreach ($orderResponse['links'] as $link) {
                $this->logger->info('[PayPal] Link found', [
                    'rel' => $link['rel'] ?? 'unknown',
                    'method' => $link['method'] ?? 'unknown',
                    'href' => isset($link['href']) ? substr($link['href'], 0, 80) . '...' : 'N/A',
                ]);

                if ($link['rel'] === 'approve') {
                    $approveUrl = $link['href'];
                    $this->logger->info('[PayPal] === CREATE PAYMENT SUCCESS ===', [
                        'approveUrl' => substr($approveUrl, 0, 150),
                    ]);
                    return $approveUrl;
                }
            }

            $this->logger->error('[PayPal] === CREATE PAYMENT FAILED ===', [
                'reason' => 'No approve link found in response',
                'availableLinks' => array_map(fn($l) => $l['rel'] ?? 'unknown', $orderResponse['links']),
            ]);
            return '';
        } catch (\Exception $e) {
            $this->logger->error('[PayPal] === CREATE PAYMENT EXCEPTION ===', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return '';
        }
    }
}
