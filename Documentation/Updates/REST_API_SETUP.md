# REST API Implementierung für TuningToolShop

## Übersicht

Diese Dokumentation beschreibt die REST API für die `tuning_tool_shop` Extension, die auf der `nnrestapi` Extension basiert.

## Installierte Komponenten

### API-Endpoints

#### 1. Product API (`Classes/Api/Product.php`)
Stellt Produktdaten bereit:
- GET /api/product/all - Alle Produkte
- GET /api/product/{uid} - Einzelnes Produkt
- GET /api/product/active - Nur aktive Produkte
- GET /api/product/search?term=... - Produktsuche
- GET /api/product/recent?limit=... - Neueste Produkte
- GET /api/product/sku?sku=... - Produkt nach SKU

#### 2. Order API (`Classes/Api/Order.php`)
Stellt Bestellungsdaten bereit:
- GET /api/order/all - Alle Bestellungen
- GET /api/order/{uid} - Einzelne Bestellung
- GET /api/order/number?number=... - Bestellung nach Nummer
- GET /api/order/email?email=... - Bestellungen nach Email
- GET /api/order/status?status=... - Bestellungen nach Status
- GET /api/order/recent?limit=... - Neueste Bestellungen
- GET /api/order/user?user=... - Bestellungen eines Benutzers

## Konfiguration

### Dependencies in ext_emconf.php

Die tuning_tool_shop Extension benötigt `nnrestapi` als Abhängigkeit:

```php
'constraints' => [
    'depends' => [
        'typo3' => '13.4.0-13.4.99',
        'nnrestapi' => '13.0.0-13.99.99',
    ],
],
```

Alternativ in `composer.json`:

```json
"require": {
    "nng/nnrestapi": "^13.0"
}
```

### nnrestapi Configuration

nnrestapi kann über TYPO3's TypoScript oder YAML konfiguriert werden. Standardmäßig:
- API-Prefix: `/api/`
- Format: JSON
- Automatische Modell-Serialisierung

## Verwendung

### cURL Beispiele

```bash
# Alle Produkte abrufen
curl -X GET "https://example.com/api/product/all"

# Produkt mit ID 1
curl -X GET "https://example.com/api/product/1"

# Aktive Produkte
curl -X GET "https://example.com/api/product/active"

# Produktsuche
curl -X GET "https://example.com/api/product/search?term=chiptuning"

# Alle Bestellungen
curl -X GET "https://example.com/api/order/all"

# Bestellung mit ID 5
curl -X GET "https://example.com/api/order/5"

# Bestellungen nach Status
curl -X GET "https://example.com/api/order/status?status=2"

# Bestellungen eines Kunden
curl -X GET "https://example.com/api/order/email?email=customer@example.com"
```

### JavaScript Fetch Beispiele

```javascript
// Alle Produkte laden
fetch('/api/product/all')
  .then(res => res.json())
  .then(data => console.log(data));

// Einzelnes Produkt
fetch('/api/product/1')
  .then(res => res.json())
  .then(data => console.log(data));

// Produktsuche
fetch('/api/product/search?term=chiptuning')
  .then(res => res.json())
  .then(data => console.log(data));

// Bestellungen eines Kunden
fetch('/api/order/email?email=max@example.com')
  .then(res => res.json())
  .then(data => console.log(data));
```

### Vue.js / React Beispiele

```javascript
// Mit axios
import axios from 'axios';

// Produkte laden
axios.get('/api/product/all')
  .then(response => console.log(response.data))
  .catch(error => console.error(error));

// Mit Query-Parametern
axios.get('/api/product/search', {
  params: { term: 'chiptuning' }
}).then(response => console.log(response.data));
```

## Authentifizierung & Zugriffskontrolle

Derzeit sind alle Endpoints public. Für produktive Umgebungen kann Authentifizierung hinzugefügt werden:

### HTTP Basic Authentication

```php
/**
 * @Api\Access("basic")
 */
public function getIndexAction(): array { ... }
```

### JWT Token Authentication

```php
/**
 * @Api\Access("token")
 */
public function getIndexAction(): array { ... }
```

### Custom Authorization

```php
/**
 * @Api\Access("admin")
 */
public function getIndexAction(): array { ... }
```

## Response-Format

Alle Endpoints geben strukturierte JSON-Responses zurück:

### Erfolgreicher Response

```json
{
  "success": true,
  "data": { /* Model oder Array von Models */ },
  "count": 10
}
```

### Fehler-Response

```json
{
  "success": false,
  "message": "Fehlerbeschreibung"
}
```

## Fehlerbehandlung

Alle API-Methoden:
1. Validieren Query-Parameter
2. Behandeln Datenbank-Fehler
3. Loggen Fehler via PSR-3 Logger
4. Geben aussagekräftige Fehlermeldungen zurück

## Performance-Tipps

1. **Lazy-Loading**: ObjectStorages werden lazy-loaded, um Performance zu verbessern
2. **Limit Parameter**: Nutze `limit` bei `recent` Endpoints
3. **Caching**: Kann via nnrestapi konfiguriert werden
4. **Query Optimization**: Die Repositories nutzen optimierte Queries

## Custom Routes erweitern

Neue Endpoints können hinzugefügt werden:

```php
/**
 * @Api\Route("/product/bestseller")
 * @Api\Access("public")
 */
public function getBestsellerAction(): array {
    // Custom Logik
}
```

## Pagination implementieren

Für große Datenmengen kann Pagination hinzugefügt werden:

```php
public function getIndexAction(int $page = 1): array
{
    $limit = 20;
    $offset = ($page - 1) * $limit;
    
    $query = $this->productRepository->createQuery();
    $query->setOffset($offset)
          ->setLimit($limit);
    
    return [
        'success' => true,
        'data' => $query->execute(),
        'page' => $page,
        'limit' => $limit,
    ];
}
```

## Sicherheit

### Best Practices

1. **HTTPS verwenden** - Immer HTTPS in Produktion
2. **CORS-Headers** - Bei Frontend von anderer Domain
3. **Rate Limiting** - Kann via nnrestapi konfiguriert werden
4. **Input Validation** - Alle Parameter validieren
5. **Output Sanitization** - nnrestapi serialisiert automatisch sicher

### CORS-Konfiguration (falls nötig)

In `.htaccess` oder Webserver-Konfiguration:

```apache
Header set Access-Control-Allow-Origin "*"
Header set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
Header set Access-Control-Allow-Headers "Content-Type, Authorization"
```

## Testing

### Manuelles Testen mit Postman

1. Kollektion erstellen
2. Endpoints hinzufügen:
   - GET http://localhost:8000/api/product
   - GET http://localhost:8000/api/order
   - etc.
3. Verschiedene Query-Parameter testen

### API-Dokumentation

Die vollständige API-Dokumentation befindet sich in `API_DOCUMENTATION.md`

## Fehlersuche

### API wird nicht angezeigt

1. nnrestapi Extension ist installiert? `composer require nng/nnrestapi`
2. Extension ist geladen? TYPO3 Backend überprüfen
3. Syntax-Fehler? `php -l Classes/Api/Product.php`
4. TYPO3 Cache geleert? `php vendor/bin/typo3 cache:flush`

### 404 Fehler bei Endpoint-Zugriff

1. Route-Naming überprüfen
2. API-Prefix korrekt? (Standard: `/api/`)
3. RouteEnhancer konfiguriert?

### Daten werden nicht angezeigt

1. Logger-Einträge überprüfen
2. Modelle haben `@Api\Endpoint()` Annotation?
3. Repositories funktionierten korrekt? (Unit Tests)

## Weiterführende Ressourcen

- [nnrestapi Dokumentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html)
- [TYPO3 REST API Quickstart](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/Quickstart/Index.html)
- [REST API Best Practices](https://restfulapi.net/)

## Kontakt & Support

- nnrestapi Entwickler: [99grad.de](https://www.99grad.de)
- Issues: [nnrestapi Repository](https://bitbucket.org/99grad-team/nnrestapi)
