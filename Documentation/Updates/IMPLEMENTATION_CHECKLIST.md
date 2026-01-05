# PayPal Integration - Implementation Checklist

Complete checklist for finishing the PayPal payment integration.

## Code Changes Completed ✅

### TypoScript Configuration
- [x] Added `settings.tuningToolShop.payment.*` to constants.typoscript
- [x] Added `settings.tuningToolShop.paypal.*` to constants.typoscript
- [x] Added payment settings mapping to setup.typoscript
- [x] Added paypal settings mapping to setup.typoscript

### PHP Classes
- [x] Added `setConfiguration()` method to PayPalPaymentHandler
- [x] Updated PaymentController to inject PayPal settings
- [x] Fixed settings paths for payment page UIDs

### FlexForm Configuration
- [x] Added sPayment sheet to Checkout.xml
- [x] Added sPayPal sheet to Checkout.xml
- [x] Added currency dropdown with EUR/USD/GBP/CHF options
- [x] Added sandbox mode checkbox
- [x] Added business email field

### Language Labels
- [x] Added flexform.sheet.payment label
- [x] Added flexform.paymentSuccessPid label
- [x] Added flexform.paymentCancelPid label
- [x] Added flexform.paymentNotifyPid label
- [x] Added flexform.sheet.paypal label
- [x] Added flexform.paypalSandbox label
- [x] Added flexform.paypalBusiness label
- [x] Added flexform.paypalCurrency label

### Documentation
- [x] Created README_PAYPAL.md
- [x] Created PAYPAL_SETUP_GUIDE.md
- [x] Created CHECKOUT_PAYPAL_INTEGRATION.md
- [x] Created INTEGRATION_SUMMARY.md
- [x] Created this checklist

## Database & Records

Before you can use PayPal payments, create:

### Payment Pages
- [ ] Create "Payment Success" page
  - Note UID for configuration
  - Content: Order confirmation message

- [ ] Create "Payment Cancelled" page
  - Note UID for configuration
  - Content: Cancellation message

- [ ] Create "IPN Notify" page
  - Note UID for configuration
  - Hidden from navigation (internal use only)

### Payment Method Record
- [ ] Navigate to list module where products are stored
- [ ] Create new "Payment Method" record with:
  - Title: `PayPal`
  - Description: `Pay with PayPal`
  - Handler Class: `Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler`
  - Is Active: `✓` (checked)
  - Sort Order: `10`

## Checkout Plugin Configuration

In TYPO3 Backend, edit your checkout plugin:

### General Sheet
- [ ] Review current settings
- [ ] Enable guest checkout if desired

### Pages Sheet
- [ ] Set confirmation page
- [ ] Set terms page
- [ ] Set privacy page
- [ ] Set cart page
- [ ] Set shop page

### **NEW: Payment Sheet** ⭐
- [ ] Set Payment Success Page (select page you created)
- [ ] Set Payment Cancel Page (select page you created)
- [ ] Set Payment Notify Page (select page you created)

### **NEW: PayPal Sheet** ⭐
- [ ] Enable Sandbox Mode (check for testing)
- [ ] Enter PayPal Business Email
- [ ] Select Currency (EUR/USD/GBP/CHF)

### Email Sheet
- [ ] Sender email
- [ ] Sender name
- [ ] Admin email

## PayPal Account Setup

### Sandbox Setup (Testing)
- [ ] Create developer account at https://developer.paypal.com
- [ ] Create sandbox business account
- [ ] Create sandbox buyer account
- [ ] Note sandbox business email
- [ ] Note sandbox currency

### Production Setup
- [ ] Have PayPal Business account ready
- [ ] Know your business email for PayPal
- [ ] Verify account supports your currency (EUR/USD/GBP/CHF)
- [ ] Enable IPN in account settings
- [ ] Document IPN endpoint (you'll need it later)

## Testing Checklist

### Sandbox Testing
1. [ ] Set checkout plugin to sandbox mode
2. [ ] Set checkout plugin to sandbox business email
3. [ ] Go to shop frontend
4. [ ] Add product to cart
5. [ ] Go to checkout
6. [ ] Fill in customer data
7. [ ] Select PayPal as payment method
8. [ ] Submit order
9. [ ] Verify redirect to sandbox.paypal.com
10. [ ] Log in with sandbox buyer account
11. [ ] Complete payment
12. [ ] Verify redirect to success page
13. [ ] Check TYPO3: Order should be marked "Paid"
14. [ ] Check TYPO3: Payment status should be "Paid"
15. [ ] Check TYPO3: Transaction ID should be populated

### Error Scenarios
- [ ] Test cancelling payment (should redirect to cancel page)
- [ ] Test with missing settings (should show error)
- [ ] Test with invalid email (should fail)

## Production Deployment

### Pre-Deployment
- [ ] Complete all sandbox testing
- [ ] Verify all pages work correctly
- [ ] Create production pages (3)
- [ ] Create production payment method record
- [ ] Have PayPal business email ready
- [ ] Verify SSL certificate is valid
- [ ] Domain is accessible from internet

### Update Configuration
- [ ] Change `sandbox = 0` in checkout plugin
- [ ] Update `business` to production email
- [ ] Update payment page UIDs to production pages
- [ ] Verify currency matches PayPal account

### PayPal Configuration
- [ ] Log in to production PayPal account
- [ ] Navigate to Account Settings → Notifications
- [ ] Enable Instant Payment Notification (IPN)
- [ ] Set IPN URL to: `https://yourdomain.com/?id=XXX&type=1641916401`
  (Replace XXX with your notify page UID)
- [ ] Save settings

### First Production Payment
- [ ] Process test payment with small amount
- [ ] Verify order status in TYPO3
- [ ] Verify transaction in PayPal account
- [ ] Verify IPN notification was received
- [ ] Check logs for any errors

## File Locations

### Configuration Files
- `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/constants.typoscript`
- `packages/tuning_tool_shop/Configuration/Sets/TuningToolShop/setup.typoscript`
- `packages/tuning_tool_shop/Configuration/FlexForms/Checkout.xml`

### PHP Classes
- `packages/tuning_tool_shop/Classes/Controller/PaymentController.php`
- `packages/tuning_tool_shop/Classes/Payment/PayPalPaymentHandler.php`

### Language Files
- `packages/tuning_tool_shop/Resources/Private/Language/locallang_be.xlf`

### Documentation
- `packages/tuning_tool_shop/README_PAYPAL.md`
- `packages/tuning_tool_shop/PAYPAL_SETUP_GUIDE.md`
- `packages/tuning_tool_shop/CHECKOUT_PAYPAL_INTEGRATION.md`
- `packages/tuning_tool_shop/INTEGRATION_SUMMARY.md`

## Troubleshooting Quick Reference

### Problem: Settings not showing in checkout plugin
- [ ] Clear TYPO3 cache
- [ ] Verify FlexForm XML syntax
- [ ] Check language labels are present

### Problem: PayPal form not submitting
- [ ] Verify business email is configured
- [ ] Check browser console for JavaScript errors
- [ ] Verify HTTPS is enabled for production

### Problem: Orders not marked as paid
- [ ] Check notify page UID is correct
- [ ] Verify IPN is enabled in PayPal
- [ ] Check TYPO3 logs for errors
- [ ] Verify page is accessible from internet

### Problem: Wrong payment page after redirect
- [ ] Verify page UIDs in FlexForm match actual pages
- [ ] Verify pages are published
- [ ] Verify site URL is correct

## Support Resources

- **PayPal Developer**: https://developer.paypal.com
- **PayPal IPN Guide**: https://developer.paypal.com/docs/api-basics/notifications/ipn/
- **TYPO3 Docs**: https://docs.typo3.org
- **Extension Code**: `Classes/Payment/` directory

## Final Verification

Before going live:
- [ ] All code changes reviewed
- [ ] Database records created
- [ ] Checkout plugin configured
- [ ] Sandbox testing completed successfully
- [ ] Production pages created
- [ ] PayPal account configured
- [ ] SSL certificate valid
- [ ] Documentation reviewed
- [ ] Team trained on new payment system
- [ ] Backup created before deployment
- [ ] Monitoring setup for payment errors

## Sign-Off

- [ ] Developer: Implementation complete
- [ ] QA: Sandbox testing passed
- [ ] Admin: Production configuration ready
- [ ] Manager: Approval for go-live

---

**Status:** ⏳ Awaiting implementation

**Last Updated:** December 2025

**Implementation Guide:** See `PAYPAL_SETUP_GUIDE.md`

**Questions?** Review the documentation files or check PayPal Developer docs.
