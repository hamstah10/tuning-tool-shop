# PayPal Integration - Standalone Setup (ohne externe Extension)

## Überblick

Die PayPal Integration ist jetzt vollständig in der `tuning_tool_shop` Extension integriert. Es wird keine separate PayPal API Extension mehr benötigt.

## Komponenten

### 1. PayPalService
- Datei: `packages/tuning_tool_shop/Classes/Service/PayPalService.php`
- Übernimmt alle PayPal API Calls
- Liest Konfiguration aus TYPO3 Extension Settings von `tuning_tool_shop`

### 2. PayPalPaymentHandler
- Datei: `packages/tuning_tool_shop/Classes/Payment/PayPalPaymentHandler.php`
- Implementiert `PaymentHandlerInterface`
- Nutzt `PayPalService` für Payment Processing
- Wird vom `PaymentController` über Dependency Injection injiziert

## TYPO3 Konfiguration

### Schritt 1: Extension konfigurieren
1. Gehe zu **Admin Tools → Extensions**
2. Suche **tuning_tool_shop**
3. Klicke auf das **Zahnrad-Icon** zum Konfigurieren

### Schritt 2: PayPal API Credentials eingeben

#### Sandbox Credentials (zum Testen)
- **PayPal Mode**: `Sandbox`
- **PayPal Sandbox Client ID**: `<deine-sandbox-client-id>`
- **PayPal Sandbox Client Secret**: `<dein-sandbox-client-secret>`

#### Live Credentials (für Production)
- **PayPal Mode**: `Live`
- **PayPal Live Client ID**: `<deine-live-client-id>`
- **PayPal Live Client Secret**: `<dein-live-client-secret>`

### Schritt 3: Return Page einrichten
- **PayPal Return Page UID**: `<page-id-für-payment-return>`
  - Dies ist die Page ID, auf die Benutzer nach PayPal Approval zurück kommen
  - Diese Page sollte ein Extbase Plugin mit dem `PaymentReturn` Action haben

### Schritt 4: PayPal URL (optional)
- Standard: `https://api-m.sandbox.paypal.com/v1` (Sandbox)
- Live: `https://api-m.paypal.com/v1` (Production)

## PayPal API Credentials besorgen

### Sandbox Credentials
1. Gehe zu https://developer.paypal.com/
2. Melde dich mit deinem PayPal Account an
3. Gehe zu **Apps & Credentials** → **Sandbox Tab**
4. Erstelle eine neue App wenn nötig
5. Kopiere **Client ID** und **Secret**

### Live Credentials
1. Gehe zu https://developer.paypal.com/
2. Gehe zu **Apps & Credentials** → **Live Tab**
3. Kopiere deine **Client ID** und **Secret**

## Payment Flow

1. **Checkout:** Benutzer wählt PayPal als Zahlungsart
2. **Order erstellen:** Order wird in TYPO3 gespeichert
3. **Redirect Action:** `PaymentController::redirectAction()` wird aufgerufen
4. **PayPal Service:** `PayPalPaymentHandler::processPayment()` nutzt `PayPalService`
5. **REST API Call:** Service erstellt Payment via PayPal REST API
6. **Approval URL:** PayPal gibt Approval URL zurück
7. **Redirect zu PayPal:** Benutzer wird zu PayPal weitergeleitet
8. **Approval:** Benutzer genehmigt Payment auf PayPal
9. **Return:** Benutzer wird zurück zur Return Page geleitet (definiert in Extension Settings)

## Troubleshooting

### Benutzer sieht blank page statt PayPal Redirect

**Check:**
1. Sind PayPal API Credentials konfiguriert?
2. Sind sie korrekt eingegeben?
3. Ist die PayPal Return Page UID gesetzt?

**Logs prüfen:**
```bash
tail -f var/log/typo3_*.log | grep -i paypal
```

### PayPal OAuth Error

```
PayPal OAuth error: ...
```

**Lösung:**
- Client ID und Client Secret überprüfen
- Richtige Credentials für Sandbox/Live Mode nutzen

### Approval URL nicht gefunden

```
PayPal: Could not find approval_url
```

**Lösung:**
- PayPal API Response prüfen (siehe Logs)
- Credentials und API Endpoint überprüfen

## Konfigurationseintrag Übersicht

| Einstellung | Typ | Beschreibung |
|---|---|---|
| `payPalMode` | select | `sandbox` oder `live` |
| `payPalUrl` | string | Base URL der PayPal API |
| `payPalSandboxClientId` | string | Sandbox Client ID |
| `payPalSandboxClientSecret` | string | Sandbox Client Secret |
| `payPalLiveClientId` | string | Live Client ID |
| `payPalLiveClientSecret` | string | Live Client Secret |
| `paypalReturnPageUid` | int | Page UID für Return nach PayPal |

## No Plugin Configuration Required

✅ **Keine zusätzliche Extension nötig**
✅ **Keine Plugin-Einbindung erforderlich**
✅ **Alles läuft über die tuning_tool_shop Extension**

Die Integration ist vollständig in der Shop Extension enthalten!
