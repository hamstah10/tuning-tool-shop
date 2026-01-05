# Klarna Setup Guide

## Step-by-Step Setup

### 1. Get API Credentials from Klarna

1. Go to [Klarna Merchant Portal](https://merchantportal.klarna.com)
2. Sign in with your Klarna account
3. Navigate to **Settings** → **API Credentials**
4. Copy your **API Key** (for Basic Authentication)
5. Note your **Merchant ID** (optional)

### 2. Configure TYPO3

#### Option A: Via Extension Configuration

Edit `ext_conf_template.txt`:

```
# cat=basic//; type=string; label=Klarna API Key
klarna.apiKey = 

# cat=basic//; type=string; label=Klarna Merchant ID
klarna.merchantId = 

# cat=basic//; type=boolean; label=Use Klarna Sandbox
klarna.sandbox = 1
```

#### Option B: Via TypoScript Setup

```typoscript
plugin.tx_tuningtoolshop {
    settings {
        klarna {
            apiKey = YOUR_API_KEY_HERE
            merchantId = YOUR_MERCHANT_ID_HERE
            sandbox = 1
        }
        payment {
            successPid = 123
            cancelPid = 124
            notifyPid = 125
        }
    }
}
```

#### Option C: Via Backend (System > Extension Configuration)

1. Go to **System** → **Extension Configuration**
2. Find **tuning_tool_shop**
3. Fill in:
   - **Klarna API Key**: Your API key
   - **Klarna Merchant ID**: Your merchant ID
   - **Use Klarna Sandbox**: Check for sandbox, uncheck for production

### 3. Create Payment Method Record

1. Go to backend main navigation
2. Create new page to store shop data (if not exists)
3. Create new record of type **PaymentMethod**:
   - **Title**: `Klarna`
   - **Handler Class**: `Hamstahstudio\TuningToolShop\Payment\KlarnaPaymentHandler`
   - **Description**: `Zahlen Sie flexibel mit Klarna`
   - **Fee**: `0.00` (optional, Klarna handles fees)
   - **Icon**: Upload Klarna logo (optional)

### 4. Create Redirect Pages

Create three TYPO3 pages for payment callbacks:

#### Success Page
- **Title**: Payment Success
- **Slug**: `/payment-success`
- **Plugin**: TuningToolShop - Payment (Payment action: success)

#### Cancel Page
- **Title**: Payment Canceled
- **Slug**: `/payment-cancel`
- **Plugin**: TuningToolShop - Payment (Payment action: cancel)

#### Notification/Webhook Page
- **Title**: Payment Notification
- **Slug**: `/payment-notify`
- **Plugin**: TuningToolShop - Payment (Payment action: notify)

### 5. Configure Page UIDs in TypoScript

```typoscript
plugin.tx_tuningtoolshop {
    settings {
        payment {
            successPid = 123  # ID of success page
            cancelPid = 124   # ID of cancel page
            notifyPid = 125   # ID of notification page
        }
    }
}
```

### 6. Configure Klarna Webhook (Production Only)

1. Go to **Klarna Merchant Portal**
2. Navigate to **Settings** → **Webhooks**
3. Add notification URL:
   ```
   https://your-domain.com/payment-notify
   ```
4. Select event types:
   - `order.created`
   - `order.cancelled`
   - `order.expired`
   - `order.captured` (optional)
   - `order.refunded` (optional)

### 7. Test Integration

#### In Sandbox Mode

1. Go to checkout
2. Select **Klarna** as payment method
3. Complete order
4. You'll be redirected to Klarna sandbox checkout
5. Use test credentials:
   - **Email**: any email
   - **Phone**: any phone number
   - **Birth date**: any valid date
6. Complete checkout
7. You'll be redirected back with authorization

#### In Production Mode

1. Ensure `klarna.sandbox = 0` in configuration
2. Ensure correct API key is set
3. Follow normal checkout process
4. Users will be redirected to live Klarna checkout

## Configuration Examples

### Minimal Configuration

```php
<?php
return [
    'tuning_tool_shop' => [
        'klarna' => [
            'apiKey' => 'your_api_key_here',
            'sandbox' => true,
        ],
    ],
];
```

### Full Configuration

```php
<?php
return [
    'tuning_tool_shop' => [
        'klarna' => [
            'apiKey' => 'your_api_key_here',
            'merchantId' => 'your_merchant_id',
            'sandbox' => false, // Production
        ],
        'payment' => [
            'successPid' => 123,
            'cancelPid' => 124,
            'notifyPid' => 125,
        ],
    ],
];
```

## Troubleshooting

### "Klarna API-Schlüssel nicht konfiguriert"
- Check extension configuration
- Verify API key is correct
- Ensure no extra whitespace in API key

### "Klarna Session konnte nicht erstellt werden"
- Verify API key is correct
- Check if you're using sandbox/production correctly
- Check network/firewall rules
- Verify order data is valid

### "Autorisierungs-Token nicht gefunden"
- User didn't complete Klarna checkout
- Callback URL is incorrect
- Check webhook configuration

### Orders not being created
- Verify payment notification page is correctly configured
- Check TYPO3 system logs
- Ensure Klarna webhook is properly set up
- Verify API key has order creation permissions

### Payment appears pending indefinitely
- Check Klarna Merchant Portal for order status
- Manually capture order in Merchant Portal (if needed)
- Review webhook logs

## Security Considerations

1. **API Key Protection**
   - Store in TYPO3 extension configuration (protected)
   - Never commit to version control
   - Use different keys for sandbox and production

2. **HTTPS Required**
   - All Klarna checkout URLs must be HTTPS
   - Verify SSL certificate is valid
   - Use secure payment callback URLs

3. **Webhook Validation**
   - Validate all webhook calls from Klarna
   - Use IP whitelisting if possible
   - Log all webhook calls

4. **PCI Compliance**
   - Klarna Payments eliminates PCI compliance burden
   - Never store card details
   - Follow Klarna security guidelines

## Switching Between Sandbox and Production

### From Sandbox to Production

1. Update `klarna.sandbox = 0`
2. Update `klarna.apiKey` to production key
3. Update webhook URLs in Klarna Merchant Portal
4. Test thoroughly with real payments (small amount)
5. Monitor first transactions carefully

### From Production to Sandbox

1. Update `klarna.sandbox = 1`
2. Update `klarna.apiKey` to sandbox key
3. Update webhook URLs to sandbox paths
4. Use test credentials only

## Support and Resources

- [Klarna Developer Docs](https://docs.klarna.com/)
- [Klarna Payments API](https://docs.klarna.com/api/payments/)
- [Klarna Merchant Portal](https://merchantportal.klarna.com)
- [Klarna Support](https://www.klarna.com/contact/)

## Next Steps

After successful setup:

1. Test with sandbox credentials
2. Create payment method in TYPO3 backend
3. Configure checkout page to include Klarna
4. Test complete checkout flow
5. Document test results
6. Plan production cutover
7. Switch to production credentials
8. Monitor first transactions

## Verification Checklist

- [ ] Klarna account created and verified
- [ ] API credentials obtained
- [ ] TYPO3 configuration updated
- [ ] Payment method record created
- [ ] Success/Cancel/Notify pages created
- [ ] Page UIDs configured in TypoScript
- [ ] Webhook URL configured (if production)
- [ ] Sandbox testing completed
- [ ] Production credentials configured
- [ ] SSL/HTTPS verified
- [ ] First production transaction tested
- [ ] Monitoring/logging configured
