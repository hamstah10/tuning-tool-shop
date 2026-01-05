# PayPal Redirect Issue - Diagnostics

## Problem
PayPal checkout redirect is not functioning. The form should auto-submit to PayPal but it appears to be failing.

## Flow Analysis

1. **CheckoutController::processAction()** (line 243)
   - Creates temporary order with PAYMENT_STATUS_PENDING
   - Redirects to `PaymentController::redirectAction()`

2. **PaymentController::redirectAction()** (lines 28-128)
   - Gets payment method and handler class
   - Instantiates PayPalPaymentHandler 
   - Passes PayPal settings via `setConfiguration()`
   - Calls `handler->processPayment($order)` which returns PaymentResult with form data
   - Renders Payment/Redirect.html template with formAction and formFields

3. **Payment/Redirect.html** template
   - Renders hidden form fields
   - Auto-submits form with JavaScript

## Possible Issues

### 1. **Missing Payment Plugin on Page**
- The Payment plugin must be placed on a page to make the redirect action accessible
- The redirect might fail if there's no Payment plugin configured

### 2. **Incorrect FlexForm PIDs**
- Payment success/cancel/notify PIDs must be configured in Checkout plugin
- If not configured, controller uses fallback PIDs (lines 83-90 in PaymentController)

### 3. **PayPal Configuration Missing**
- Settings must be configured in Checkout plugin "PayPal" tab:
  - Business email (required for payment to work)
  - Sandbox mode
  - Currency

### 4. **Form Rendering Issue**
- The Redirect.html template may not be rendering correctly
- The JavaScript that submits the form might not execute

### 5. **Session/CSRF Issue**
- TYPO3 might be blocking the form submission due to session issues

## Solutions to Test

1. Check browser console for JavaScript errors
2. Verify Payment plugin exists on a page
3. Verify Checkout plugin has PayPal settings configured
4. Check if form HTML is rendering (view source)
5. Enable debug logging in PaymentController
