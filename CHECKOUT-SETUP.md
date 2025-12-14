# Checkout & Payment Setup

## Problem Gelöst: PayPal Checkout funktioniert nun korrekt

Das Problem, dass Bestellungen ohne Zahlung gespeichert wurden, ist behoben. Jetzt wird die Bestellung nur bei bestätigter Zahlung von PayPal aktualisiert.

## Einrichtung der Zahlungsmethoden

Bevor der Checkout funktioniert, müssen Sie die Zahlungsmethoden im TYPO3 Backend einrichten.

### Schritt 1: Storage-Seite ermitteln

1. Gehen Sie im Backend zu `Web > Page`
2. Notieren Sie sich die UID einer Seite, wo die Shop-Daten gespeichert werden (z.B. UID: 56)

### Schritt 2: PaymentMethods manuell erstellen

**Schnell:** Führen Sie dieses SQL im phpMyAdmin oder MySQL aus:

```sql
INSERT INTO tx_tuningtoolshop_domain_model_paymentmethod (
    pid, tstamp, crdate, deleted, hidden, 
    title, description, is_active, sort_order, handler_class
) VALUES (
    56, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0, 0,
    'PayPal', 'Bezahlen Sie sicher mit PayPal', 1, 1,
    'Hamstahstudio\\TuningToolShop\\Payment\\PayPalPaymentHandler'
);
```

**Manuell:** Oder erstellen Sie im TYPO3 Backend:

1. Gehen Sie zu `Web > Datensätze bearbeiten`
2. Wählen Sie die Seite aus (ID 56 oder Ihre Storage-PID)
3. Klicken Sie auf "tuning_tool_shop_domain_model_paymentmethod" erstellen
4. Füllen Sie folgende Werte ein:
   - **Title**: `PayPal`
   - **Description**: `Bezahlen Sie sicher mit PayPal`
   - **Handler Class**: `Hamstahstudio\TuningToolShop\Payment\PayPalPaymentHandler`
   - **Is Active**: `Ja`
   - **Sort Order**: `1`

### Schritt 3: Checkout-Element konfigurieren

Im Content Element des Checkout-Plugins:

1. Klicken Sie auf das Checkout-Plugin
2. Gehen Sie zur FlexForm und konfigurieren Sie unter "Pages":
   - **Storage Pid**: Wählen Sie die Storage-Seite
   - **Confirmation Pid**: Wählen Sie die Seite mit dem Checkout-Confirmation-Element
   - **Cart Pid**: Wählen Sie die Seite mit dem Cart-Element
   - **Shop Pid**: Wählen Sie die Shop/Produkt-Seite

3. Gehen Sie zum Tab "Payment" und konfigurieren Sie:
   - **Payment Success Pid**: Seite nach erfolgreicher Zahlung
   - **Payment Cancel Pid**: Seite bei Zahlungsabbruch
   - **Payment Notify Pid**: IPN-Callback-Seite (sollte die Checkout-Seite sein)

4. Gehen Sie zum Tab "PayPal" und konfigurieren Sie:
   - **PayPal Sandbox**: `Ja` (für Tests) oder `Nein` (für Produktion)
   - **PayPal Business**: Ihre PayPal-Email (z.B. sb-xxxxx@business.example.com für Sandbox)
   - **Currency**: `EUR`

## Ablauf der Zahlungsverarbeitung

1. **Bestellung erstellen**: Benutzer füllt Checkout aus
   - Status: `PAYMENT_PENDING` (nicht bezahlt)

2. **Zu PayPal weiterleiten**: Das Checkout-Formular wird angezeigt
   - PayPal erhält die Bestelldaten

3. **Benutzer zahlt auf PayPal**

4. **Rückkehr vom PayPal**: Benutzer wird zur Success-Seite weitergeleitet
   - Status bleibt `PAYMENT_PENDING` (nur Info-Nachricht angezeigt)
   - Warenkorb wird geleert

5. **IPN-Callback von PayPal**: PayPal bestätigt die Zahlung
   - Handler verifiziert die IPN-Nachricht mit PayPal
   - Status wird auf `PAYMENT_STATUS_PAID` und `STATUS_CONFIRMED` gesetzt

## Sicherheit

- **IPN-Verifizierung**: Alle Zahlungsbestätigungen werden mit PayPal verifiziert
- **Keine automatische Bestätigung**: Bestellungen werden nur bei echten PayPal-Callbacks aktualisiert
- **Schutz vor Manipulation**: Der Return-URL kann nicht die Bestellung bestätigen

## Debugging

Wenn der Checkout nicht funktioniert, überprüfen Sie:

1. **Logs**: `var/log/typo3_*.log`
2. **Database**: Hat die PaymentMethod die richtige `handler_class`?
3. **Cache**: `php vendor/bin/typo3 cache:flush`
