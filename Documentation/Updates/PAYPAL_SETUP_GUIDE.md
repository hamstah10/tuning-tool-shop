# PayPal Integration Setup Guide

Complete checklist for setting up PayPal payments in the Tuning Tool Shop.

## Phase 1: Prerequisites & Environment

- [ ] PayPal Business Account created (or sandbox account for testing)
- [ ] TYPO3 installation running (v11+)
- [ ] Shop extension installed with PayPal handler
- [ ] SSL certificate valid for production domain
- [ ] Database migrations applied (`php typo3 database:migrate`)

## Phase 2: PayPal Account Configuration

### Production Account:
1. [ ] Log in to https://www.paypal.com
2. [ ] Go to Account Settings → Business Tools
3. [ ] Find your Business Email address (required for configuration)
4. [ ] Note your business email (e.g., shop@yourbusiness.com)

### Sandbox Account (for testing):
1. [ ] Go to https://developer.paypal.com
2. [ ] Create developer account if needed
3. [ ] Under "Apps & Credentials", create sandbox business account
4. [ ] Note the sandbox business email
5. [ ] Create a sandbox buyer account for testing payments

## Phase 3: TYPO3 Configuration

### Step 1: Create Payment Pages

In TYPO3 Backend, create three new pages:

1. **Payment Success Page**
   - Title: "Payment Success" or similar
   - [ ] Create page and note UID (e.g., 123)
   - Create content showing order confirmation

2. **Payment Cancel Page**
   - Title: "Payment Cancelled" or similar
   - [ ] Create page and note UID (e.g., 124)
   - Create content with cancellation notice

3. **Payment Notify Page**
   - Title: "IPN Notification Handler"
   - [ ] Create page and note UID (e.g., 125)
   - Can be hidden from navigation (it's for PayPal only)
   - Don't add any content to this page

### Step 2: Update TypoScript Constants

Edit file: `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/constants.typoscript`

Replace the payment configuration with your actual page UIDs and PayPal details:

```typoscript
settings.tuningToolShop {
    payment {
        successPid = 123      # Change to your Success Page UID
        cancelPid = 124       # Change to your Cancel Page UID
        notifyPid = 125       # Change to your Notify Page UID
    }
    paypal {
        sandbox = 1           # Use 1 for testing, 0 for production
        business = shop@yourbusiness.com    # Your PayPal business email
        currency = EUR        # Your store currency
    }
}
```

## Phase 4: Create Payment Method

In TYPO3 Backend:

1. [ ] Navigate to List Module (choose folder with products)
2. [ ] Create new record: "tx_tuningtoolshop_domain_model_paymentmethod"
3. [ ] Fill in these fields:

   | Field | Value |
   |-------|-------|
   | Title | PayPal |
   | Description | Pay with PayPal |
   | Handler Class | `Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler` |
   | Is Active | ✓ (checked) |
   | Sort Order | 10 |
   | Icon | (optional, select PayPal logo) |

4. [ ] Save the record

## Phase 5: Cart Plugin Configuration

In TYPO3 Backend, edit your Cart plugin:

1. [ ] Go to the page with Cart plugin
2. [ ] Edit the plugin content element
3. [ ] Set "Checkout Page" to your Checkout page UID
4. [ ] Save

## Phase 6: Testing (Sandbox Mode)

### Prerequisites for Testing:
- [ ] Constants have `sandbox = 1`
- [ ] sandbox business email configured
- [ ] Sandbox buyer account created

### Testing Procedure:

1. [ ] Go to shop frontend
2. [ ] Add products to cart
3. [ ] Proceed to checkout
4. [ ] Fill in customer details
5. [ ] **Select "PayPal" as payment method**
6. [ ] Submit order
7. [ ] You should be **redirected to sandbox.paypal.com**
8. [ ] Log in with sandbox buyer credentials
9. [ ] Complete the payment
10. [ ] Should return to success page

### Verify Payment Processing:

1. [ ] Check TYPO3 order status (should be "Confirmed")
2. [ ] Check payment status (should be "Paid")
3. [ ] Transaction ID should be populated
4. [ ] Customer receives order confirmation

## Phase 7: Production Deployment

### Before Going Live:

1. [ ] Test thoroughly in sandbox mode (Phase 6)
2. [ ] Verify all pages work correctly
3. [ ] Update constants.typoscript:
   ```typoscript
   paypal {
       sandbox = 0           # Switch to production
       business = real@business.email.com  # Your live email
       currency = EUR
   }
   ```
4. [ ] Test one real payment with small amount
5. [ ] Verify transaction appears in PayPal account
6. [ ] Verify TYPO3 order is marked as paid

### Configure PayPal IPN (Important):

1. [ ] Log in to https://www.paypal.com
2. [ ] Go to Account Settings → Notifications
3. [ ] Enable "Instant Payment Notification (IPN)"
4. [ ] Set IPN URL to:
   ```
   https://adventskalender-typo3.de/?id=125&type=1641916401
   ```
   (Replace with your notify page URL)
5. [ ] Save settings

### Enable HTTPS:
- [ ] Ensure your domain has valid SSL certificate
- [ ] All shop pages should use HTTPS
- [ ] Verify certificate is recognized by PayPal

## Phase 8: Monitoring & Maintenance

### Regular Checks:

- [ ] Monitor TYPO3 logs for payment errors: `var/log/typo3_*.log`
- [ ] Verify orders are being marked as paid
- [ ] Check PayPal account for disputes or chargebacks
- [ ] Review transaction reports monthly

### Troubleshooting:

**Orders not marked as paid:**
- Check notify page UID is correct
- Verify IPN is enabled in PayPal
- Check firewall allows PayPal IPs
- Check TYPO3 logs for errors

**Redirect not working:**
- Verify page UIDs are correct
- Check pages are published in TYPO3
- Verify site base URL in TYPO3 is correct

**Currency mismatch:**
- Ensure currency matches between shop and PayPal
- PayPal account must support configured currency

## Configuration Files Modified

The following files have been updated to support PayPal integration:

1. `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/constants.typoscript`
   - Added payment and paypal settings sections

2. `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/setup.typoscript`
   - Added payment and paypal configuration mappings

3. `Classes/Payment/PayPalPaymentHandler.php`
   - Added `setConfiguration()` method for runtime configuration

4. `Classes/Controller/PaymentController.php`
   - Updated to pass PayPal settings to handler
   - Updated to use new payment configuration structure

## Support & Documentation

- PayPal IPN Documentation: https://developer.paypal.com/docs/api-basics/notifications/ipn/
- PayPal Sandbox: https://developer.paypal.com
- TYPO3 Logs: `var/log/`
- Extension README: `README_PAYPAL.md`

## Quick Reference

### Key Configuration Values

| Setting | File | Line | Purpose |
|---------|------|------|---------|
| `payment.successPid` | constants.typoscript | 26 | Page ID for success redirect |
| `payment.cancelPid` | constants.typoscript | 27 | Page ID for cancellation |
| `payment.notifyPid` | constants.typoscript | 28 | Page ID for IPN callback |
| `paypal.sandbox` | constants.typoscript | 31 | Test/Production mode |
| `paypal.business` | constants.typoscript | 32 | PayPal business email |
| `paypal.currency` | constants.typoscript | 33 | Currency code |

### Payment Flow Diagram

```
[Customer] → [Shop] → [PaymentController::redirect]
    ↓
[PayPal Form] → [PayPal] → [Customer redirected]
    ↓
[Success/Cancel Page] ← [PaymentController::success/cancel]
    ↓
[IPN Notify] → [PaymentController::notify] → [Order Updated]
```
