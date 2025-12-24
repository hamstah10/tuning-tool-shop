# TuningToolShop REST API

Die REST API stellt Produkt- und Bestellungsdaten für externe Systeme bereit.

## Features

✅ **Produktverwaltung**
- Alle Produkte abrufen
- Einzelnes Produkt laden
- Nach Produkten suchen
- Nach SKU suchen
- Aktive Produkte filtern
- Neueste Produkte laden

✅ **Bestellungsverwaltung**
- Alle Bestellungen abrufen
- Einzelne Bestellung laden
- Nach Bestellnummer suchen
- Nach Kundenemails filtern
- Nach Status filtern
- Bestellungen eines Benutzers laden
- Neueste Bestellungen laden

✅ **Entwicklerfreundlich**
- JSON Responses
- Strukturierte Error-Handling
- Logging
- Dokumentierte Endpoints
- Verwendungsbeispiele für mehrere Sprachen

## Quick Start

### Alle Produkte laden
```bash
curl https://example.com/api/product
```

### Bestellungen eines Kunden
```bash
curl "https://example.com/api/order/email?email=customer@example.com"
```

### Nach Produkten suchen
```bash
curl "https://example.com/api/product/search?term=chiptuning"
```

## Dokumentation

- 📖 **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - Vollständige API-Dokumentation mit allen Endpoints
- 🚀 **[REST_API_SETUP.md](REST_API_SETUP.md)** - Installation & Konfiguration
- 📋 **[API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)** - Schnelle Übersicht
- 💻 **[INTEGRATION_EXAMPLES.md](INTEGRATION_EXAMPLES.md)** - Code-Beispiele für verschiedene Sprachen

## Endpoints

### Produkte
| GET | `/api/product` | Alle Produkte |
| GET | `/api/product/{uid}` | Einzelnes Produkt |
| GET | `/api/product/active` | Aktive Produkte |
| GET | `/api/product/search?term=...` | Produktsuche |
| GET | `/api/product/recent?limit=...` | Neueste Produkte |
| GET | `/api/product/sku?sku=...` | Nach SKU suchen |

### Bestellungen
| GET | `/api/order` | Alle Bestellungen |
| GET | `/api/order/{uid}` | Einzelne Bestellung |
| GET | `/api/order/number?number=...` | Nach Bestellnummer |
| GET | `/api/order/email?email=...` | Nach Email |
| GET | `/api/order/status?status=...` | Nach Status |
| GET | `/api/order/recent?limit=...` | Neueste Bestellungen |
| GET | `/api/order/user?user=...` | Bestellungen eines Benutzers |

## Technologie

- **Framework**: TYPO3 13.4 + nnrestapi Extension
- **Format**: JSON
- **Authentifizierung**: Derzeit public (konfigurierbar)
- **Language**: PHP 8.2
- **ORM**: Extbase/Doctrine

## Installation

1. nnrestapi Extension installieren
2. API-Klassen sind automatisch registriert
3. Cache leeren: `php vendor/bin/typo3 cache:flush`
4. Fertig!

## Response-Format

```json
{
  "success": true,
  "data": [ /* Modell oder Array */ ],
  "count": 10
}
```

Fehler:
```json
{
  "success": false,
  "message": "Fehlerbeschreibung"
}
```

## Verwendungsbeispiele

### PHP
```php
$response = file_get_contents('https://example.com/api/product');
$products = json_decode($response, true);
```

### JavaScript
```javascript
fetch('/api/product')
  .then(res => res.json())
  .then(data => console.log(data.data));
```

### Python
```python
import requests
response = requests.get('https://example.com/api/product')
products = response.json()
```

## Support

- 📚 [nnrestapi Dokumentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html)
- 🐛 [Issue Tracker](https://bitbucket.org/99grad-team/nnrestapi)

---

© 2024 TuningToolShop - REST API powered by nnrestapi
