# nnrestapi Dokumentation Guide

Die REST API ist mit **nnrestapi** dokumentiert. Die Dokumentation wird automatisch generiert aus den Kommentaren in den PHP-Klassen.

## Wie die Dokumentation funktioniert

Alle Kommentare über den Methoden in `Classes/Api/` werden automatisch:

1. **Im TYPO3 Backend** angezeigt (wenn nnrestapi Module aktiviert ist)
2. **Als Markdown formatiert** - du kannst Überschriften, Listen, Code-Blöcke, Tabellen verwenden
3. **Mit Beispielen** versehen - Request und Response Beispiele

## Struktur der Dokumentation

### Markdown Elemente

Die API-Klassen verwenden folgende Markdown-Struktur:

```php
/**
 * ## Endpoint-Titel
 *
 * Beschreibung des Endpoints
 *
 * ### Parameter
 *
 * - **name**: Beschreibung
 *
 * ### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": {}
 * }
 * ```
 *
 * @Api\Route("/path")
 * @Api\Access("public")
 * @return array
 */
public function getExampleAction(): array
{
    // Implementation
}
```

## Endpoint-Dokumentation

### Product API

Die Dokumentation für die Product API findet sich in:
`Classes/Api/Product.php`

**Documentierte Endpoints:**

#### 1. Alle Produkte
- **Methode**: `getIndexAction()`
- **Route**: GET /api/product
- **Dokumentation**: Alle Produkte abrufen mit Beispiel-Responses

#### 2. Nach Suchbegriff suchen
- **Methode**: `getSearchAction()`
- **Route**: GET /api/product/search
- **Parameter**: term
- **Dokumentation**: Mit Markdown-Beispielen und Code-Blöcken

#### 3. Aktive Produkte
- **Methode**: `getActiveAction()`
- **Route**: GET /api/product/active
- **Dokumentation**: Filter für aktive Produkte

#### 4. Neueste Produkte
- **Methode**: `getRecentAction()`
- **Route**: GET /api/product/recent
- **Parameter**: limit
- **Dokumentation**: Mit Limit-Parameter Erklärung

#### 5. Produkt nach SKU
- **Methode**: `getSkuAction()`
- **Route**: GET /api/product/sku
- **Parameter**: sku
- **Dokumentation**: Mit Error-Beispiel wenn SKU nicht gefunden

### Order API

Die Dokumentation für die Order API findet sich in:
`Classes/Api/Order.php`

**Documentierte Endpoints:**

#### 1. Alle Bestellungen
- **Methode**: `getIndexAction()`
- **Route**: GET /api/order
- **Dokumentation**: Bestellungen abrufen

#### 2. Nach Bestellnummer
- **Methode**: `getNumberAction()`
- **Route**: GET /api/order/number
- **Parameter**: number
- **Dokumentation**: Mit Beispiel-Bestellnummer

#### 3. Nach Kundenemails
- **Methode**: `getEmailAction()`
- **Route**: GET /api/order/email
- **Parameter**: email
- **Dokumentation**: Mit E-Mail Beispiel

#### 4. Nach Status filtern
- **Methode**: `getStatusAction()`
- **Route**: GET /api/order/status
- **Parameter**: status
- **Dokumentation**: Mit Tabelle aller Status-Codes

#### 5. Neueste Bestellungen
- **Methode**: `getRecentAction()`
- **Route**: GET /api/order/recent
- **Parameter**: limit
- **Dokumentation**: Mit Limit-Parameter

#### 6. Nach Benutzer
- **Methode**: `getUserAction()`
- **Route**: GET /api/order/user
- **Parameter**: user
- **Dokumentation**: Mit Benutzer-ID Beispiel

## Markdown Features in der Dokumentation

### Überschriften

```markdown
## Haupttitel
### Untertitel
#### Weitere Ebene
```

### Listen

```markdown
- Element 1
- Element 2
  - Verschachteltes Element

### Nummerierte Liste

1. Schritt 1
2. Schritt 2
```

### Code-Blöcke

#### JSON Response

```markdown
```json
{
  "success": true,
  "data": {}
}
```
```

#### HTTP Request

```markdown
```
GET /api/product/search?term=test
```
```

### Tabellen

```markdown
| Header 1 | Header 2 |
|----------|----------|
| Wert 1   | Wert 2   |
```

### Fett und Kursiv

```markdown
**Fett Text**
*Kursiv Text*
```

## Wo wird die Dokumentation angezeigt?

### TYPO3 Backend

Wenn nnrestapi konfiguriert ist, findet sich eine Dokumentation unter:
- Module → nnrestapi (falls vorhanden)
- Die Dokumentation wird als HTML rendert aus dem Markdown

### In den Kommentaren selbst

Die Dokumentation sitzt direkt im PHP Code:

```php
/**
 * ## Mein Endpoint
 * 
 * Beschreibung mit Markdown
 * 
 * @Api\Access("public")
 */
public function getMyAction(): array {}
```

## Struktur der Dokumentation

Empfohlene Struktur für jeden Endpoint:

```
1. ## Titel (was tut der Endpoint?)
2. Kurzbeschreibung
3. ### Parameter (falls vorhanden)
   - Aufzählung aller Parameter
4. ### Beispiele
   - Beispiel 1 (Request)
   - Beispiel 1 (Response)
5. ### Fehler (falls relevant)
   - Error Response Beispiele
```

## Praktische Beispiele

### Einfacher Endpoint

```php
/**
 * ## Get All Users
 *
 * Returns a list of all users.
 *
 * ### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": [
 *     {"uid": 1, "name": "User 1"}
 *   ]
 * }
 * ```
 *
 * @Api\Access("public")
 */
public function getIndexAction(): array {}
```

### Endpoint mit Parametern

```php
/**
 * ## Search Products
 *
 * Search for products by term.
 *
 * ### Parameter
 *
 * - **term** (required): Search keyword
 *
 * ### Examples
 *
 * #### Request
 *
 * ```
 * GET /api/product/search?term=chiptuning
 * ```
 *
 * #### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "count": 5,
 *   "data": [...]
 * }
 * ```
 *
 * @Api\Route("/product/search")
 * @Api\Access("public")
 */
public function getSearchAction(): array {}
```

### Endpoint mit Tabelle

```php
/**
 * ## Filter by Status
 *
 * Get orders by status.
 *
 * ### Status Codes
 *
 * | Code | Status |
 * |------|--------|
 * | 0 | New |
 * | 1 | Processing |
 * | 2 | Confirmed |
 *
 * @Api\Route("/order/status")
 * @Api\Access("public")
 */
public function getStatusAction(): array {}
```

## Best Practices

### 1. Klare Titel

```markdown
## ❌ FALSCH
/** Get shit from db **/

## ✅ RICHTIG
/**
 * ## Alle Produkte abrufen
 * ...
```

### 2. Parameter dokumentieren

```markdown
## ❌ FALSCH
/** Gets products **/

## ✅ RICHTIG
/**
 * ## Produkte abrufen
 *
 * ### Parameter
 *
 * - **limit**: Anzahl der Produkte (default: 10)
```

### 3. Konkrete Beispiele

```markdown
## ❌ FALSCH
/** Returns products **/

## ✅ RICHTIG
/**
 * ### Examples
 *
 * #### 5 neueste Produkte
 *
 * ```
 * GET /api/product/recent?limit=5
 * ```
```

### 4. Response Struktur zeigen

```markdown
## ❌ FALSCH
/** Returns something **/

## ✅ RICHTIG
/**
 * ### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": [...],
 *   "count": 10
 * }
 * ```
```

## Debugging

### Syntax überprüfen

Überprüfe die Markdown-Syntax:

```bash
php -l Classes/Api/Product.php
```

### In TYPO3 Backend anschauen

1. Gehe zum TYPO3 Backend
2. Suche nach nnrestapi Modul
3. Die Dokumentation sollte angezeigt werden

### Cache leeren

Falls die Dokumentation nicht aktualisiert wird:

```bash
php vendor/bin/typo3 cache:flush
```

## Weitere Informationen

- [nnrestapi Dokumentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/WritingDoc/Index.html)
- [Markdown Guide](https://www.markdownguide.org/cheat-sheet/)
- [nnrestapi Examples](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/Examples/Index.html)

## Änderungen vornehmen

### Eine neue Methode dokumentieren

1. Öffne `Classes/Api/Product.php` oder `Classes/Api/Order.php`
2. Schreibe den Kommentar mit Markdown
3. Schreibe die Methode
4. Leere den Cache: `php vendor/bin/typo3 cache:flush`

### Beispiel: Neue Methode hinzufügen

```php
/**
 * ## Produkte nach Kategorie
 *
 * Ruft alle Produkte einer bestimmten Kategorie ab.
 *
 * ### Parameter
 *
 * - **category** (erforderlich): Die Kategorie-ID
 *
 * ### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": [...],
 *   "count": 10
 * }
 * ```
 *
 * @Api\Route("/product/category")
 * @Api\Access("public")
 * @return array
 */
public function getCategoryAction(): array
{
    // Implementation...
}
```

---

**Die Dokumentation ist jetzt im nnrestapi-Stil strukturiert und wird automatisch generiert!**
