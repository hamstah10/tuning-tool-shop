# PayPal Checkout Redirect - Fix Applied

## Problem
The PayPal checkout redirect was not functioning properly. When users completed the checkout form, they were not being redirected to PayPal to complete the payment.

## Root Cause
The issue was in how the CheckoutController was building the URI to redirect to the PaymentController.

The original code at line 243 in CheckoutController used:
```php
return $this->redirect('redirect', 'Payment', null, ['order' => $tempOrder->getUid()]);
```

This approach uses TYPO3 Extbase's built-in redirect method, which internally tries to find a page that has the Payment plugin placed on it. However, the Payment plugin was not placed on any content page, so the URI builder couldn't resolve the route.

## Solution
Changed the redirect mechanism to use explicit URI building with `uriFor()` and `redirectToUri()`:

```php
$checkoutPid = (int)$this->request->getAttribute('site')->getRootPageId();
$paymentUri = $this->uriBuilder
    ->reset()
    ->setTargetPageUid($checkoutPid)
    ->setCreateAbsoluteUri(true)
    ->uriFor('redirect', ['order' => $tempOrder->getUid()], 'Payment', 'tuning_tool_shop', 'Payment');

return $this->redirectToUri($paymentUri);
```

This explicitly:
1. Targets the root page (which has the Checkout plugin)
2. Uses `uriFor()` to build a proper URI for the Payment::redirect action
3. Specifies the extension (`tuning_tool_shop`) and plugin (`Payment`) names
4. Creates an absolute URI for the redirect

## Additional Changes
Added route enhancer configuration for the Payment plugin in `/config/sites/tfd/config.yaml`:

```yaml
TuningToolShopPayment:
  type: Extbase
  extension: TuningToolShop
  plugin: Payment
  namespace: tx_tuningtoolshop_payment
  limitToPages:
    - 28
  routes:
    - routePath: /redirect
      _controller: 'Payment::redirect'
    - routePath: /success
      _controller: 'Payment::success'
    - routePath: /cancel
      _controller: 'Payment::cancel'
    - routePath: /notify
      _controller: 'Payment::notify'
  defaultController: 'Payment::redirect'
```

This ensures proper URL routing for all Payment plugin actions.

## Files Modified
1. `/packages/tuning_tool_shop/Classes/Controller/CheckoutController.php` (line 242-251)
2. `/config/sites/tfd/config.yaml` (added TuningToolShopPayment route enhancer)

## Testing
After these changes, the payment flow should work as follows:

1. User completes checkout form
2. CheckoutController::processAction creates a temporary order with PAYMENT_PENDING status
3. User is redirected to PaymentController::redirectAction
4. PaymentController renders the Payment/Redirect.html template with the form
5. The form auto-submits to PayPal
6. User completes payment on PayPal
7. User is redirected back to success/cancel page based on payment result
8. PayPal sends IPN callback to notifyAction to finalize the order

## Cache Clearing
Run the following command to ensure caches are cleared:
```bash
php vendor/bin/typo3 cache:flush
```

This is required because route enhancers are cached.
