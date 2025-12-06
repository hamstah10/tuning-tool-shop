# Stripe Integration für Tuning Tool Shop

Diese Dokumentation beschreibt die Integration von Stripe als Zahlungsanbieter.

## Voraussetzungen

- Stripe-Konto (https://stripe.com)
- Composer-Paket `stripe/stripe-php` (wird automatisch installiert)

## Installation

1. **Composer-Abhängigkeit hinzufügen** (falls noch nicht vorhanden):
```bash
composer require stripe/stripe-php
```

2. **Stripe API-Keys konfigurieren**:
   - Live-Keys aus Stripe Dashboard kopieren
   - In den Backend-Einstellungen eintragen: Stripe API Key, Webhook Secret, Publishable Key

## Konfiguration

### Constants (TypoScript)

```typoscript
settings.tuningToolShop.stripe {
    apiKey = sk_test_... oder sk_live_...
    webhookSecret = whsec_...
    publishableKey = pk_test_... oder pk_live_...
}
```

### Setup im Backend

1. **Zahlungsart erstellen**:
   - Im Backend: Shop > Zahlungsarten
   - Neue Zahlungsart "Stripe" erstellen
   - Handler-Klasse: `Hamstahstudio\TuningToolShop\Payment\StripePaymentHandler`
   - Icon hochladen (optional)
   - Aktivieren und speichern

2. **Webhook konfigurieren**:
   - Im Stripe Dashboard: Webhooks konfigurieren
   - Endpoint-URL: `https://domain.de/index.php?eID=stripe_webhook`
   - Events aktivieren:
     - `payment_intent.succeeded`
     - `payment_intent.payment_failed`
     - `charge.refunded`

## API-Keys besorgen

### Test-Modus:
1. https://dashboard.stripe.com/test/apikeys aufrufen
2. "Restricted API keys" unter "Secret key" verwenden
3. Publishable Key kopieren

### Live-Modus:
1. https://dashboard.stripe.com/apikeys aufrufen
2. Live-Secrets verwenden
3. WICHTIG: Nur mit Live-Keys in Produktion verwenden

## Dateien

### Controller
- `Classes/Controller/StripeController.php` - Zahlungsabwicklung und Webhooks

### Payment Handler
- `Classes/Payment/StripePaymentHandler.php` - Stripe API-Integration
- `Classes/Payment/PaymentHandlerInterface.php` - Interface für Payment Handler

### Templates
- `Resources/Private/Templates/Stripe/Checkout.html` - Stripe Checkout-Seite

### Repository-Erweiterungen
- `Classes/Domain/Repository/OrderRepository.php` - `findOneByTransactionId()` Methode

## Workflow

### 1. Bestellung erstellen
```
Kunde -> Checkout-Formular ausfüllen -> Order in Datenbank speichern
```

### 2. Zahlungsintent erstellen
```
POST /typo3conf/ext/tuning_tool_shop/Classes/Controller/StripeController.php
Anfrage: { order: orderId }
Antwort: { clientSecret: "pi_secret_...", orderId: 123 }
```

### 3. Client-seitige Zahlungsbestätigung
```
Stripe.js -> confirmCardPayment(clientSecret) -> Zahlungsmittel verifizieren
```

### 4. Server-seitige Verifikation
```
Zahlung erfolgreich -> Order Status = CONFIRMED, Payment Status = PAID
```

### 5. Webhook-Verarbeitung
```
Stripe Server -> Webhook Event -> Stripe-Controller -> Order aktualisieren
```

## Rückerstattung

Rückerstattungen können über den Stripe-Controller abgewickelt werden:

```php
$handler = new StripePaymentHandler($apiKey, '', '');
$handler->refundPayment($chargeId, $amount); // $amount optional
```

## Fehlerbehandlung

### Häufige Fehler:

1. **"Stripe API key not configured"**
   - API-Key in den Constants eintragen

2. **"Invalid signature" bei Webhook**
   - Webhook Secret überprüfen
   - Webhook-URL korrekt registrieren

3. **"Payment verification failed"**
   - Transaction ID nicht gespeichert
   - Order nicht gefunden

## Testing

### Test-Kartendaten (im Test-Modus):
- **Erfolgreiche Zahlung**: 4242 4242 4242 4242
- **Authentifizierung erforderlich**: 4000 0025 0000 3155
- **Zahlung ablehnen**: 4000 0000 0000 0002
- **CVC-Fehler**: 4000 0000 0000 0127

Beliebiges zukünftiges Ablaufdatum und beliebige CVC verwenden.

### Webhook testen:
```bash
stripe listen --forward-to localhost/index.php?eID=stripe_webhook
```

## Sicherheit

⚠️ **WICHTIG**:
- Niemals API-Keys in Frontend-Code speichern (außer publishableKey)
- Nur webhookSecret Server-seitig verwenden
- TLS/HTTPS für alle Zahlungsseiten erzwingen
- PCI-DSS Compliance beachten
- Stripe.js für Kartendaten verwenden (nie selbst sammeln)

## Weitere Ressourcen

- Stripe Docs: https://docs.stripe.com
- Payment Intents API: https://docs.stripe.com/payments/payment-intents
- Webhooks: https://docs.stripe.com/webhooks
- Testing: https://docs.stripe.com/testing
