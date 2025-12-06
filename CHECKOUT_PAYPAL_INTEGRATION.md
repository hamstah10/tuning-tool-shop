# Checkout - PayPal Integration

This document describes the PayPal payment integration in the checkout flow.

## Overview

The PayPal integration has been fully integrated into the checkout process. Customers can now select PayPal as a payment method during the checkout process and complete their payments securely.

## Integration Points

### 1. Checkout Template

File: `Resources/Private/Templates/Checkout/Index.html`

**Lines 119-146:** Payment Methods Section
- Displays all available payment methods
- Uses radio buttons for selection
- Shows payment method icon, title, and description
- Supports optional payment fees

```html
<!-- Zahlungsart -->
<section class="tts-checkout-section">
    <h2 class="tts-checkout-section__title">
        <span class="tts-checkout-section__number">4</span>
        Zahlungsart
    </h2>
    <div class="tts-payment-methods">
        <f:for each="{paymentMethods}" as="paymentMethod">
            <div class="tts-payment-method">
                <f:form.radio property="paymentMethod" id="payment_{paymentMethod.uid}" value="{paymentMethod.uid}" class="tts-form-radio" />
                <label for="payment_{paymentMethod.uid}" class="tts-payment-method__label">
                    <!-- Icon, Title, Description, Fee -->
                </label>
            </div>
        </f:for>
    </div>
</section>
```

### 2. Checkout FlexForm Configuration

File: `Configuration/FlexForms/Checkout.xml`

**New Sections Added:**

#### sPayment Sheet
Configures payment-related page UIDs:
- `settings.payment.successPid` - Page for successful payments
- `settings.payment.cancelPid` - Page for cancelled payments
- `settings.payment.notifyPid` - Page for IPN notifications

#### sPayPal Sheet
Configures PayPal-specific settings:
- `settings.paypal.sandbox` - Enable sandbox mode for testing
- `settings.paypal.business` - PayPal business email address
- `settings.paypal.currency` - Currency for transactions (EUR, USD, GBP, CHF)

### 3. Language Labels

File: `Resources/Private/Language/locallang_be.xlf`

Added labels for the new configuration sections:

```xml
<!-- Payment Configuration -->
<trans-unit id="flexform.sheet.payment">
    <source>Zahlung</source>
</trans-unit>
<trans-unit id="flexform.paymentSuccessPid">
    <source>Erfolgreiches Zahlung - Seite</source>
</trans-unit>
<trans-unit id="flexform.paymentCancelPid">
    <source>Abgebrochene Zahlung - Seite</source>
</trans-unit>
<trans-unit id="flexform.paymentNotifyPid">
    <source>Zahlungsbestätigung (IPN) - Seite</source>
</trans-unit>

<!-- PayPal Configuration -->
<trans-unit id="flexform.sheet.paypal">
    <source>PayPal</source>
</trans-unit>
<trans-unit id="flexform.paypalSandbox">
    <source>PayPal Sandbox-Modus (Test)</source>
</trans-unit>
<trans-unit id="flexform.paypalBusiness">
    <source>PayPal Business-E-Mail</source>
</trans-unit>
<trans-unit id="flexform.paypalCurrency">
    <source>Währung</source>
</trans-unit>
```

## Configuration Hierarchy

The payment settings can be configured at two levels:

### 1. Global Configuration (TypoScript Constants)
Default values for all checkout plugins
```typoscript
settings.tuningToolShop.payment {
    successPid = 0
    cancelPid = 0
    notifyPid = 0
}
settings.tuningToolShop.paypal {
    sandbox = 1
    business = shop@example.com
    currency = EUR
}
```

### 2. Plugin-Level Configuration (FlexForm)
Per-checkout-plugin settings that override global defaults
- Set in TYPO3 Backend when editing the checkout plugin
- Takes precedence over TypoScript constants

## Checkout Payment Flow

1. **Customer visits Checkout Page**
   - CheckoutController::index loads payment methods
   - Template displays available payment methods including PayPal

2. **Customer selects PayPal**
   - Radio button for PayPal is selected
   - Order form includes selected payment method UID

3. **Customer submits Order**
   - CheckoutController::process creates new Order
   - Sets the selected PayPal payment method on Order
   - Redirects to PaymentController::redirect

4. **Payment Processing**
   - PaymentController::redirect is triggered
   - PayPalPaymentHandler is instantiated
   - Plugin settings (PayPal config) are passed to handler
   - Handler builds PayPal payment form
   - Form auto-submits to PayPal (sandbox or production)

5. **Customer Completes Payment on PayPal**
   - Customer logs in to PayPal
   - Reviews payment amount
   - Completes payment

6. **PayPal Redirects Back**
   - Success: Customer redirected to successPid page
   - Cancel: Customer redirected to cancelPid page

7. **IPN Notification**
   - PayPal sends IPN notification to notifyPid
   - PaymentController::notify handles callback
   - Order status updated with payment result

## Database Records Required

### Payment Method Record

In TYPO3 Backend, create a "Payment Method" record:

**Table:** `tx_tuningtoolshop_domain_model_paymentmethod`

| Field | Value |
|-------|-------|
| Title | PayPal |
| Description | Pay with PayPal |
| Handler Class | `Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler` |
| Is Active | Yes (1) |
| Sort Order | 10 |
| Icon | (optional) |

This record defines PayPal as an available payment method for checkout.

## Implementation Details

### Settings Available in PaymentController

When using the Checkout plugin, these settings are automatically available:

```php
$this->settings['payment']['successPid']
$this->settings['payment']['cancelPid']
$this->settings['payment']['notifyPid']
$this->settings['paypal']['sandbox']
$this->settings['paypal']['business']
$this->settings['paypal']['currency']
```

### Settings Passed to PayPalPaymentHandler

```php
if ($handler instanceof PayPalPaymentHandler && isset($this->settings['paypal'])) {
    $handler->setConfiguration($this->settings['paypal']);
}
```

This allows:
- Runtime configuration injection
- Per-plugin PayPal settings
- Fallback to global configuration

## Frontend Display

The checkout template automatically displays:

1. **Payment Methods List**
   - All active payment methods from database
   - Radio buttons for selection
   - Icon, title, and description
   - Optional payment fees

2. **Selected Payment Method Processing**
   - Form submission includes selected payment method UID
   - Order is created with payment method reference
   - Payment handler processes the payment

## FlexForm Configuration Screenshot

When editing the Checkout plugin in TYPO3 Backend, you'll see:

### Payment Sheet
- Success Page selector
- Cancel Page selector
- Notify Page selector

### PayPal Sheet
- Sandbox Mode checkbox (enable for testing)
- Business Email field (required)
- Currency dropdown (EUR, USD, GBP, CHF)

## SSL/HTTPS Requirement

For production use:
- All checkout pages must use HTTPS
- PayPal will reject non-HTTPS IPN notifications
- Valid SSL certificate required
- Domain must be accessible from the internet

## Testing in Sandbox Mode

1. Set `settings.paypal.sandbox = 1` in FlexForm
2. Use sandbox PayPal business email
3. Create sandbox buyer account at developer.paypal.com
4. Complete test payments
5. Verify order status changes to "Paid"

## Production Deployment

1. Create three production pages:
   - Success page (for completed payments)
   - Cancel page (for cancelled payments)
   - Notify page (for IPN notifications)

2. Configure FlexForm:
   - Set success/cancel/notify page UIDs
   - Set `sandbox = 0` for production
   - Enter production PayPal business email
   - Select currency

3. Create PaymentMethod record with handler class

4. Configure PayPal IPN:
   - Log in to PayPal account
   - Enable IPN notifications
   - Set IPN URL to notify page URL

5. Test with small payment amount

6. Monitor logs for errors

## Files Modified for Checkout Integration

1. **Configuration/FlexForms/Checkout.xml**
   - Added sPayment sheet with page PIDs
   - Added sPayPal sheet with PayPal settings
   - Currency selection dropdown

2. **Resources/Private/Language/locallang_be.xlf**
   - Added payment configuration labels
   - Added PayPal configuration labels
   - All labels in German

## Next Steps

1. Update your checkout plugin FlexForm with:
   - Payment success, cancel, and notify page UIDs
   - PayPal business email
   - Currency (EUR, USD, GBP, CHF)

2. Create PaymentMethod record for PayPal

3. Test payment flow in sandbox mode

4. Deploy to production with proper configuration

See `PAYPAL_SETUP_GUIDE.md` for detailed step-by-step instructions.
