# Klarna Payment Integration

## Overview

This document describes the Klarna payment integration for the Tuning Tool Shop extension. Klarna is integrated as a payment handler that implements the `PaymentHandlerInterface`.

## Architecture

The Klarna payment handler follows the same pattern as existing payment providers (Stripe, PayPal):

- **Handler Class**: `Hamstahstudio\TuningToolShop\Payment\KlarnaPaymentHandler`
- **Interface**: `PaymentHandlerInterface`
- **Flow**: Redirect-based checkout (user is redirected to Klarna checkout)

## Features

- Create Klarna sessions with order data
- Redirect to Klarna checkout
- Handle authorization callbacks
- Create orders from authorization tokens
- Verify payment status
- Refund payments
- Support for both production and sandbox environments

## Setup

### 1. Get Klarna API Credentials

1. Register at [Klarna Merchant Portal](https://merchantportal.klarna.com)
2. Create an application and get your credentials:
   - **API Key** (use as `username:password` for Basic Auth, only the API key is needed)
   - **Merchant ID** (optional, for reference)

### 2. Configure Extension

Add Klarna configuration to your extension settings:

```php
// In ext_conf_template.txt or via TYPO3 backend
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop'] = [
    'klarna' => [
        'apiKey' => 'your_klarna_api_key',
        'merchantId' => 'your_merchant_id',
        'sandbox' => true, // Use sandbox environment
    ],
];
```

Or via TypoScript:

```typoscript
plugin.tx_tuningtoolshop {
    settings {
        klarna {
            apiKey = your_klarna_api_key
            merchantId = your_merchant_id
            sandbox = 1
        }
    }
}
```

### 3. Create Payment Method in TYPO3 Backend

1. Go to backend
2. Create new payment method record
3. Set:
   - **Title**: "Klarna"
   - **Handler Class**: `Hamstahstudio\TuningToolShop\Payment\KlarnaPaymentHandler`
   - **Icon/Logo**: Optional
   - **Description**: "Zahlen Sie flexibel mit Klarna"

## Payment Flow

1. **User selects Klarna** in checkout
2. **Order created** with status "new"
3. **Redirect to Payment** → `PaymentController::redirectAction()` called
4. **Session creation** → Klarna session created with order details
5. **Redirect to Klarna** → User redirected to Klarna checkout
6. **User authorizes** → Klarna redirects back with `authorization_token`
7. **Create order** → Backend creates order in Klarna system
8. **Mark as paid** → Order marked as "confirmed" and payment status "paid"

## API Endpoints Used

### Session Creation
```
POST /payments/v1/sessions
```
Creates a Klarna payment session with order and customer details.

### Order Creation
```
POST /payments/v1/authorizations/{authorization_token}/orders
```
Creates an order from the authorization token.

### Verification
```
GET /ordermanagement/v1/orders/{order_id}
```
Retrieves order status and details.

### Refunds
```
POST /ordermanagement/v1/orders/{order_id}/refunds
```
Creates a refund for the order.

## Order Line Details

Each order line includes:
- `type`: "physical" for products, "shipping_fee" for shipping
- `name`: Product or shipping name
- `quantity`: Number of items
- `unit_price`: Price in cents (EUR)
- `tax_rate`: 1900 (19% German VAT)
- `total_amount`: Total price in cents
- `total_tax_amount`: Tax amount in cents

## Sandbox vs. Production

### Sandbox
- **API URL**: `https://api.sandbox.klarna.com`
- **Checkout URL**: `https://checkout.sandbox.klarna.com`
- **Setting**: `sandbox = 1` (true)

### Production
- **API URL**: `https://api.klarna.com`
- **Checkout URL**: `https://checkout.klarna.com`
- **Setting**: `sandbox = 0` (false)

## Testing in Sandbox

### Test Credentials
Use the following test credentials in Klarna sandbox:

- **Email**: any email address
- **Phone**: any valid phone number
- **Birth date**: any valid date
- **SSN**: For Sweden: use test SSN like "1212121212"

### Test Card Numbers
Use any card number with expiry date in the future and any CVC.

## Error Handling

Errors are handled gracefully:
- Missing API key → "Klarna API-Schlüssel nicht konfiguriert"
- Failed session creation → "Klarna Session konnte nicht erstellt werden"
- API errors → Detailed error message from Klarna
- Missing token → "Autorisierungs-Token nicht gefunden"

## Security

- API key should be stored in TYPO3 extension configuration (protected)
- All API calls use HTTPS
- Basic authentication with API key
- Orders are verified via API before marking as paid
- Callbacks are validated

## Methods in KlarnaPaymentHandler

### Public Methods

```php
processPayment(Order $order): PaymentResult
```
Initiates Klarna payment by creating a session and returning redirect URL.

```php
handleCallback(array $parameters): PaymentResult
```
Processes Klarna callback with authorization token and creates order.

```php
verifyPayment(string $orderId): ?array
```
Verifies payment status with Klarna.

```php
refundPayment(string $orderId, ?float $amount = null): PaymentResult
```
Creates a refund in Klarna system.

### Protected Methods

```php
createSession(Order $order, string $apiKey, bool $sandbox): string
```
Creates a Klarna session and returns session ID.

```php
createOrder(string $authorizationToken, string $apiKey, bool $sandbox): array
```
Creates an order from authorization token.

```php
getAuthorizationUrl(string $sessionId, bool $sandbox): string
```
Returns Klarna checkout URL for the session.

```php
apiRequest(string $method, string $url, array $payload, string $apiKey): array
```
Makes HTTP requests to Klarna API with authentication.

## Currency and Localization

- **Currency**: EUR (Euros)
- **Locale**: de-DE (German)
- **Country**: Derived from billing address
- **Tax Rate**: 19% (German VAT standard)

## Integration with PaymentController

The `PaymentController` handles the complete payment flow:

1. Validates order and payment method
2. Instantiates Klarna handler
3. Passes Klarna settings to handler
4. Processes payment and handles result
5. Updates order status based on payment result

## References

- [Klarna Payments API](https://docs.klarna.com/api/payments/)
- [Klarna Order Management API](https://docs.klarna.com/api/ordermanagement/)
- [Klarna Merchant Portal](https://merchantportal.klarna.com)
