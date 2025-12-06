# PayPal Integration for Tuning Tool Shop

This document provides instructions for setting up and configuring PayPal payments in the Tuning Tool Shop extension.

## Overview

The PayPal integration uses the IPN (Instant Payment Notification) mechanism to handle payment callbacks. The shop extension provides:

- **PayPalPaymentHandler**: Handles payment processing and callbacks
- **Payment Configuration**: Via TypoScript constants and settings
- **Payment Flow**: Redirect to PayPal → Process payment → Return to shop

## Prerequisites

1. **PayPal Account**: You need a PayPal Business account
2. **transactor-paypal Extension**: Already installed as a dependency
3. **TYPO3 Pages**: You need to create dedicated pages for payment success/cancel/notify

## Configuration Steps

### 1. Create Payment Pages

Create three new TYPO3 pages and note their UIDs:
- **Success Page**: Shown after successful payment
- **Cancel Page**: Shown when user cancels payment
- **Notify Page**: IPN callback endpoint (hidden from frontend, just for PayPal)

### 2. Configure TypoScript Constants

Edit `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/constants.typoscript`:

```typoscript
settings.tuningToolShop {
    payment {
        successPid = 123      # Replace with your success page UID
        cancelPid = 124       # Replace with your cancel page UID
        notifyPid = 125       # Replace with your notify page UID
    }
    paypal {
        sandbox = 1           # Set to 0 for production
        business = shop@example.com  # Your PayPal business email
        currency = EUR        # Payment currency
    }
}
```

### 3. Create PaymentMethod Database Record

In TYPO3 Backend:

1. Navigate to the list module where you store products
2. Create a new "Payment Method" record with:
   - **Title**: PayPal
   - **Description**: Pay with PayPal
   - **Handler Class**: `Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler`
   - **Active**: Checked
   - **Sort Order**: e.g., 10

### 4. Configure PayPal Account

#### Sandbox Setup (Testing):
1. Go to https://developer.paypal.com
2. Create a sandbox business account
3. In `constants.typoscript`, set `sandbox = 1`

#### Production Setup:
1. In PayPal account settings, enable IPN notifications
2. Set IPN URL to: `https://yourdomain.com/path-to-notify-page/?type=1641916401`
3. In `constants.typoscript`:
   - Set `sandbox = 0`
   - Set `business` to your PayPal email
4. Ensure your shop SSL certificate is valid

### 5. Configure Frontend Cart

In your cart plugin configuration, set the checkout page UID.

## Payment Flow

1. **User initiates checkout** on the cart page
2. **Selects PayPal** as payment method
3. **Redirected to PaymentController::redirect** action
4. **Form auto-submits** to PayPal (sandbox or production)
5. **PayPal processes payment** and redirects back to success/cancel page
6. **IPN notification** is sent to notify page for verification
7. **Order status** is updated based on payment result

## Testing

### Sandbox Testing:
1. Set `sandbox = 1` in constants
2. Create a sandbox buyer account on https://developer.paypal.com
3. Use sandbox credentials to complete test payments
4. Check the notify page logs for IPN handling

### Local Testing:
For local development without SSL, you can:
- Use PayPal's sandbox environment
- Test the payment flow using tools like ngrok for HTTPS tunneling
- Manually update order status for testing

## Troubleshooting

### Payment IPN Not Being Received
- Verify IPN is enabled in PayPal account settings
- Check notification URL matches your configuration
- Ensure your site is accessible from the internet (not localhost)
- Check TYPO3 extension logs in var/log/typo3

### "Business Email Not Configured"
- Verify `business` setting in constants.typoscript
- Ensure email matches your PayPal business account email

### Wrong Redirect After Payment
- Check `payment.successPid` and `payment.cancelPid` UIDs are correct
- Verify pages exist and are published in TYPO3

## Files Modified

- `constants.typoscript`: Added payment and PayPal settings
- `setup.typoscript`: Added settings configuration
- `Classes/Payment/PayPalPaymentHandler.php`: Added `setConfiguration()` method
- `Classes/Controller/PaymentController.php`: Updated to pass PayPal settings to handler

## API Reference

### PayPalPaymentHandler

```php
public function setConfiguration(array $config): void
// Allows passing PayPal configuration at runtime

public function processPayment(Order $order): PaymentResult
// Processes the payment and returns form/redirect data

public function handleCallback(array $parameters): PaymentResult
// Handles IPN callback from PayPal

public function buildReturnUrls(int $successPid, int $cancelPid, int $notifyPid): array
// Builds return URLs for PayPal redirect
```

## Security Considerations

- Always use HTTPS in production
- Keep PayPal credentials (business email) in TypoScript, not in public files
- Verify IPN signatures in production (recommended enhancement)
- Test thoroughly in sandbox before going live
- Monitor order status updates for discrepancies

## Future Enhancements

- Implement PayPal IPN signature verification
- Add webhook support for modern PayPal REST API
- Support for PayPal Commerce Platform
- Better error handling and logging

## Support

For issues or questions, refer to:
- PayPal Developer Documentation: https://developer.paypal.com/docs
- TYPO3 Extension Documentation
- Tuning Tool Shop Extension README
