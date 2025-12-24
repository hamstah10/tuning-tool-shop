# TuningToolShop REST API

Die REST API stellt Produkt- und Bestellungsdaten für externe Systeme bereit. Sie basiert auf der `nnrestapi` Extension.

## Basis-URL

```
/api
```

## Authentifizierung

Derzeit sind alle Endpoints mit `@Api\Access("public")` konfiguriert. Für produktive Umgebungen sollte eine Authentifizierung hinzugefügt werden.

---

## Produkte (Products)

### GET /api/product
Alle Produkte abrufen

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "uid": 1,
      "title": "Produkt 1",
      "sku": "SKU001",
      "price": 99.99,
      "specialPrice": 79.99,
      "description": "Beschreibung...",
      "stock": 50,
      "isActive": true
    }
  ],
  "count": 1
}
```

---

### GET /api/product/{uid}
Einzelnes Produkt nach UID abrufen

**Beispiel:**
```
GET /api/product/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "uid": 1,
    "title": "Produkt 1",
    "sku": "SKU001",
    "price": 99.99,
    "specialPrice": 79.99,
    "description": "Beschreibung...",
    "stock": 50,
    "isActive": true
  }
}
```

---

### GET /api/product/active
Nur aktive Produkte abrufen

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 25
}
```

---

### GET /api/product/search?term=Chiptuning
Produkte nach Suchbegriff suchen

**Query Parameter:**
- `term` (erforderlich): Suchbegriff

**Beispiel:**
```
GET /api/product/search?term=Chiptuning
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 5
}
```

---

### GET /api/product/recent?limit=10
Neueste Produkte abrufen

**Query Parameter:**
- `limit` (optional, default: 10): Anzahl der Produkte

**Beispiel:**
```
GET /api/product/recent?limit=5
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 5
}
```

---

### GET /api/product/sku?sku=ABC123
Produkt nach SKU abrufen

**Query Parameter:**
- `sku` (erforderlich): Artikel-Nummer

**Beispiel:**
```
GET /api/product/sku?sku=ABC123
```

**Response:**
```json
{
  "success": true,
  "data": {
    "uid": 1,
    "sku": "ABC123",
    "title": "Produkt",
    ...
  }
}
```

---

## Bestellungen (Orders)

### GET /api/order
Alle Bestellungen abrufen

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "uid": 1,
      "orderNumber": "ORD-2024-001",
      "customerEmail": "customer@example.com",
      "customerName": "Max Mustermann",
      "total": 199.99,
      "status": 2,
      "paymentStatus": 1,
      "createdAt": "2024-01-15T10:30:00+01:00"
    }
  ],
  "count": 1
}
```

---

### GET /api/order/{uid}
Einzelne Bestellung nach UID abrufen

**Beispiel:**
```
GET /api/order/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "uid": 1,
    "orderNumber": "ORD-2024-001",
    "customerEmail": "customer@example.com",
    "customerName": "Max Mustermann",
    "customerFirstName": "Max",
    "customerLastName": "Mustermann",
    "billingCity": "München",
    "total": 199.99,
    "status": 2,
    "paymentStatus": 1,
    "createdAt": "2024-01-15T10:30:00+01:00"
  }
}
```

---

### GET /api/order/number?number=ORD-2024-001
Bestellung nach Bestellnummer abrufen

**Query Parameter:**
- `number` (erforderlich): Bestellnummer

**Beispiel:**
```
GET /api/order/number?number=ORD-2024-001
```

**Response:**
```json
{
  "success": true,
  "data": {
    "uid": 1,
    "orderNumber": "ORD-2024-001",
    ...
  }
}
```

---

### GET /api/order/email?email=customer@example.com
Bestellungen nach Kundenemails abrufen

**Query Parameter:**
- `email` (erforderlich): E-Mail-Adresse des Kunden

**Beispiel:**
```
GET /api/order/email?email=customer@example.com
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 3
}
```

---

### GET /api/order/status?status=2
Bestellungen nach Status filtern

**Query Parameter:**
- `status` (erforderlich): Status-Nummer

**Status-Codes:**
- `0` = Neu
- `1` = In Bearbeitung
- `2` = Bestätigt
- `3` = Versendet
- `4` = Abgeschlossen
- `5` = Storniert

**Beispiel:**
```
GET /api/order/status?status=2
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 15
}
```

---

### GET /api/order/recent?limit=10
Neueste Bestellungen abrufen

**Query Parameter:**
- `limit` (optional, default: 10): Anzahl der Bestellungen

**Beispiel:**
```
GET /api/order/recent?limit=5
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 5
}
```

---

### GET /api/order/user?user=123
Bestellungen eines Frontend-Benutzers abrufen

**Query Parameter:**
- `user` (erforderlich): Benutzer-ID

**Beispiel:**
```
GET /api/order/user?user=123
```

**Response:**
```json
{
  "success": true,
  "data": [...],
  "count": 2
}
```

---

## Error Responses

Fehlgeschlagene Requests geben folgende Response zurück:

```json
{
  "success": false,
  "message": "Error message describing what went wrong"
}
```

---

## cURL Beispiele

### Produkt abrufen
```bash
curl -X GET "https://example.com/api/product/1"
```

### Nach Produkten suchen
```bash
curl -X GET "https://example.com/api/product/search?term=Chiptuning"
```

### Bestellungen eines Kunden abrufen
```bash
curl -X GET "https://example.com/api/order/email?email=customer@example.com"
```

### Bestellungen mit Status abrufen
```bash
curl -X GET "https://example.com/api/order/status?status=2"
```

---

## JavaScript Beispiele

### Alle Produkte laden
```javascript
fetch('/api/product')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

### Produkt nach ID laden
```javascript
const productId = 1;
fetch(`/api/product/${productId}`)
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

### Nach Produkten suchen
```javascript
const searchTerm = 'Chiptuning';
fetch(`/api/product/search?term=${encodeURIComponent(searchTerm)}`)
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

### Bestellungen eines Kunden abrufen
```javascript
const email = 'customer@example.com';
fetch(`/api/order/email?email=${encodeURIComponent(email)}`)
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

---

## Installation & Setup

### 1. nnrestapi Extension installieren
Die Extension ist bereits installiert.

### 2. API-Klassen registrieren
Die API-Klassen in `Classes/Api/` werden automatisch erkannt.

### 3. Extension abhängigkeiten
Die tuning_tool_shop Extension benötigt `nnrestapi` als Abhängigkeit in `ext_emconf.php`.

---

## Notes

- Alle Endpoints geben JSON zurück
- Timestamps sind im ISO 8601 Format
- Pagination kann durch Custom Routes erweitert werden
- Für sensible Daten sollte eine Authentifizierung hinzugefügt werden
