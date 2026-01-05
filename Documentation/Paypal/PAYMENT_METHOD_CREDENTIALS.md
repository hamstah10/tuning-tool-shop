# Payment Method Credentials - Feature Implementation

## Overview
Added support for storing API credentials and endpoints for payment methods. This allows payment handlers to access their respective API configuration securely through the TYPO3 backend.

## Changes Made

### 1. Database Schema Updates
Added four new columns to `tx_tuningtoolshop_domain_model_paymentmethod`:
- `client_id` (VARCHAR(500)): Stores the API key, Client ID, or similar authentication identifier
- `secret` (VARCHAR(500)): Stores the API secret or password for authentication
- `api_url` (VARCHAR(2048)): Stores the API endpoint URL (e.g., Sandbox or Production URL)
- `is_sandbox` (TINYINT(1)): Boolean flag indicating if Sandbox mode is enabled (default: 1)

**File**: `ext_tables.sql` (lines 122-123)

### 2. Domain Model
Updated the `PaymentMethod` model to include the new properties and getters/setters:

**File**: `Classes/Domain/Model/PaymentMethod.php`
- Added `protected string $clientId = ''`
- Added `protected string $secret = ''`
- Added `protected string $apiUrl = ''`
- Added `protected bool $isSandbox = true`
- Added `getClientId()` and `setClientId(string)`
- Added `getSecret()` and `setSecret(string)`
- Added `getApiUrl()` and `setApiUrl(string)`
- Added `getIsSandbox()` and `setIsSandbox(bool)`

### 3. TCA (Type Configuration Array)
Added field configuration for the backend form:

**File**: `Configuration/TCA/tx_tuningtoolshop_domain_model_paymentmethod.php`
- `client_id` field with type `input` (max 500 chars)
- `secret` field with type `input` (max 500 chars)
- `api_url` field with type `input` (max 2048 chars)
- `is_sandbox` field with type `check` (toggle checkbox, default: 1)
- New tab "API-Zugangsdaten" (API Credentials) for organizing credential fields

### 4. Localization
Added German labels for the new fields:

**File**: `Resources/Private/Language/locallang_db.xlf`
- `tx_tuningtoolshop_domain_model_paymentmethod.credentials` = "API-Zugangsdaten"
- `tx_tuningtoolshop_domain_model_paymentmethod.client_id` = "Client ID / API Key"
- `tx_tuningtoolshop_domain_model_paymentmethod.secret` = "Secret / API Secret"
- `tx_tuningtoolshop_domain_model_paymentmethod.api_url` = "API URL"
- `tx_tuningtoolshop_domain_model_paymentmethod.is_sandbox` = "Sandbox-Modus"

### 5. Database Migration
Created a migration script for safe database updates:

**File**: `Migrations/Code/Version20251226000000AddPaymentMethodCredentials.php`
- Checks if columns already exist before adding them
- Provides rollback functionality

## Usage in Payment Handlers

### Accessing Credentials in PaymentHandlers

Payment handlers can now access credentials from the PaymentMethod:

```php
// In PaymentController or PaymentHandler
$paymentMethod = $order->getPaymentMethod();
$clientId = $paymentMethod->getClientId();
$secret = $paymentMethod->getSecret();

// Use credentials with payment API
$handler->setConfiguration([
    'client_id' => $clientId,
    'secret' => $secret,
]);
```

### Example: Payment Handler Implementation

```php
// In any PaymentHandler (PayPal, Stripe, Klarna, etc.)
public function processPayment(Order $order): PaymentResult
{
    $paymentMethod = $order->getPaymentMethod();
    
    // Get all credentials from database
    $clientId = $paymentMethod->getClientId();
    $secret = $paymentMethod->getSecret();
    $apiUrl = $paymentMethod->getApiUrl();
    $isSandbox = $paymentMethod->getIsSandbox();
    
    // Use credentials and endpoint with payment API
    $accessToken = $this->getAccessToken($clientId, $secret, $isSandbox);
    
    // Make API request to configured endpoint
    $environment = $isSandbox ? 'Sandbox' : 'Production';
    $response = $this->makePaymentRequest($apiUrl, $accessToken, $order);
    
    // Log the environment being used
    $this->logger->info("Payment processed in {$environment} environment");
    
    // ... rest of payment processing
}
```

## Backend Usage

### Configuring Payment Methods

In the TYPO3 Backend, payment methods now have a new "API-Zugangsdaten" tab:

1. Navigate to `Web > Datensätze bearbeiten`
2. Select the payment method record
3. Go to the "API-Zugangsdaten" tab
4. Enter the following fields:
   - **Client ID / API Key**: Your API key or client ID
   - **Secret / API Secret**: Your API secret or password
   - **API URL**: The endpoint URL (e.g., `https://api.sandbox.paypal.com/v1/` for PayPal Sandbox)
   - **Sandbox-Modus**: Enable/disable sandbox mode (toggle checkbox)
5. Save the record

**Note**: The "Sandbox-Modus" toggle is enabled by default. Disable it when switching to production.

## Security Considerations

1. **Password Field Rendering**: The `secret` field uses TYPO3's password type, which:
   - Masks the value in the backend interface
   - Does NOT encrypt the value in the database
   - Is suitable for API secrets that are already encrypted/hashed

2. **Recommended**: For additional security, consider:
   - Using TYPO3's encryption utilities for storing credentials
   - Restricting backend access to payment method records
   - Using environment variables for sensitive credentials instead

3. **API Keys**: Never commit actual credentials to version control. Use:
   - `.env` files (excluded from Git)
   - Environment variable injection
   - Secure credential management systems

## Migration Notes

### For Existing Installations

If updating from a version without these fields:

1. The database migration will automatically create the columns if missing
2. Existing payment methods will have empty credentials
3. You must manually enter credentials in the backend for each payment method

### Commands

To manually run the database migration:

```bash
# Clear TYPO3 cache
php vendor/bin/typo3 cache:flush

# Run schema updates
# TYPO3 will automatically apply schema changes from ext_tables.sql
```

## Field Specifications

### Client ID / API Key (`client_id`)
- Type: Text input
- Max length: 500 characters
- Description: Stores API key, Client ID, Merchant ID, or similar
- Example: `YOUR_PAYPAL_CLIENT_ID_HERE`

### Secret / API Secret (`secret`)
- Type: Text input
- Max length: 500 characters
- Description: Stores API secret, password, or authentication token
- Example: `YOUR_PAYPAL_SECRET_HERE`

### API URL (`api_url`)
- Type: Text input (URL)
- Max length: 2048 characters
- Description: Stores the API endpoint URL for the payment provider
- Example: `https://api.sandbox.paypal.com/v1/` (Sandbox) or `https://api.paypal.com/v1/` (Production)

### Sandbox Mode (`is_sandbox`)
- Type: Checkbox toggle
- Default: Enabled (1)
- Description: Indicates if the payment method is in Sandbox/Test mode (1) or Production mode (0)
- Disabled: Payment processing uses production credentials and endpoints
- Examples:
  - Enabled: Tests with sandbox API, no real transactions
  - Disabled: Real transactions with production API

## Files Modified

1. `ext_tables.sql` - Added four columns to payment method table
2. `Classes/Domain/Model/PaymentMethod.php` - Added properties and methods
3. `Configuration/TCA/tx_tuningtoolshop_domain_model_paymentmethod.php` - Added field configuration
4. `Resources/Private/Language/locallang_db.xlf` - Added labels

## Files Added

1. `Migrations/Code/Version20251226000000AddPaymentMethodCredentials.php` - Database migration script (for reference)

## Future Enhancements

- Add encryption for stored credentials using TYPO3's encryption utilities
- Add support for environment variable fallbacks
- Add credential validation in the backend
- Add credential testing functionality in the backend form
