# REST API - Quick Reference

## Produkte

| Methode | URL | Parameter | Beschreibung |
|---------|-----|-----------|-------------|
| GET | `/api/product` | - | Alle Produkte |
| GET | `/api/product/1` | uid | Einzelnes Produkt |
| GET | `/api/product/active` | - | Nur aktive Produkte |
| GET | `/api/product/search` | term | Nach Suchbegriff suchen |
| GET | `/api/product/recent` | limit (opt) | Neueste Produkte |
| GET | `/api/product/sku` | sku | Nach SKU suchen |

## Bestellungen

| Methode | URL | Parameter | Beschreibung |
|---------|-----|-----------|-------------|
| GET | `/api/order` | - | Alle Bestellungen |
| GET | `/api/order/1` | uid | Einzelne Bestellung |
| GET | `/api/order/number` | number | Nach Bestellnummer |
| GET | `/api/order/email` | email | Nach Kundenemails |
| GET | `/api/order/status` | status | Nach Status filtern |
| GET | `/api/order/recent` | limit (opt) | Neueste Bestellungen |
| GET | `/api/order/user` | user | Nach Benutzer-ID |

## Response-Format

```json
{
  "success": true,
  "data": { /* Modell-Daten */ },
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

## Status-Codes für Bestellungen

- `0` = Neu
- `1` = In Bearbeitung
- `2` = Bestätigt
- `3` = Versendet
- `4` = Abgeschlossen
- `5` = Storniert

## Beispiel-Requests

### Produkt laden
```
GET /api/product/1
```

### Produkte suchen
```
GET /api/product/search?term=chiptuning
```

### Bestellungen nach Status
```
GET /api/order/status?status=2
```

### Kundenbestellungen
```
GET /api/order/email?email=customer@example.com
```

## Links

- [Vollständige Dokumentation](./API_DOCUMENTATION.md)
- [Setup & Konfiguration](./REST_API_SETUP.md)
