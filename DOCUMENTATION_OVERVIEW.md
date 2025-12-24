# TuningToolShop REST API - Dokumentations-Übersicht

## 📚 Dokumentationsdateien

### API-Dokumentation

#### 1. **NNRESTAPI_DOCUMENTATION_GUIDE.md** ⭐ NEUE DOKUMENTATION
- Wie die nnrestapi-Dokumentation funktioniert
- Struktur und Markdown-Elemente
- Best Practices für Endpoint-Dokumentation
- Praktische Beispiele
- Debugging-Tipps

Dies ist die **neue Dokumentation im nnrestapi-Stil**, die direkt in den PHP-Dateien sitzt!

#### 2. **API_README.md**
- Quick Start Guide
- Übersicht aller Endpoints
- Verwendungsbeispiele für verschiedene Sprachen

#### 3. **API_DOCUMENTATION.md**
- Vollständige Dokumentation aller Endpoints
- Detaillierte Response-Beispiele
- cURL & JavaScript Beispiele

#### 4. **API_QUICK_REFERENCE.md**
- Tabellarische Übersicht
- Status-Codes
- Kurze Beispiele

#### 5. **REST_API_SETUP.md**
- Installation & Konfiguration
- Dependencies
- Performance-Tipps
- Security Best Practices
- Custom Routes erweitern
- Fehlersuche

#### 6. **INTEGRATION_EXAMPLES.md**
- Code-Beispiele für:
  - bash/curl
  - PHP
  - Python
  - JavaScript/Node.js
- Sync-Skripte & Cron-Jobs
- Error Handling

#### 7. **API_IMPLEMENTATION_SUMMARY.txt**
- Implementierungs-Summary
- Status und Checkliste

---

## 🎯 Neue Dokumentation (im Code)

Die API ist jetzt **direkt im Code dokumentiert** mit Markdown-Kommentaren im nnrestapi-Stil:

### Product API (`Classes/Api/Product.php`)

```php
/**
 * ## Alle Produkte abrufen
 *
 * Ruft alle Produkte aus der Datenbank ab.
 *
 * ### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": [...],
 *   "count": 1
 * }
 * ```
 *
 * @Api\Access("public")
 */
public function getIndexAction(int $uid = null): array { ... }
```

### Order API (`Classes/Api/Order.php`)

```php
/**
 * ## Bestellung nach Bestellnummer
 *
 * Sucht eine Bestellung nach ihrer Bestellnummer.
 *
 * ### Parameter
 *
 * - **number** (erforderlich): Die Bestellnummer
 *
 * ### Examples
 *
 * #### Bestellung abrufen
 *
 * ```
 * GET /api/order/number?number=ORD-2024-001
 * ```
 *
 * @Api\Route("/order/number")
 * @Api\Access("public")
 */
public function getNumberAction(): array { ... }
```

---

## 📂 Dateien-Struktur

```
packages/tuning_tool_shop/
├── Classes/Api/
│   ├── Product.php                ← Mit Markdown-Dokumentation
│   ├── Order.php                  ← Mit Markdown-Dokumentation
│   ├── Article.php
│   ├── Demo.php
│   └── TuningShop.php
│
├── DOKUMENTATION:
├── NNRESTAPI_DOCUMENTATION_GUIDE.md    ← 📖 Guide zur Dokumentation
├── API_README.md                       ← Quick Start
├── API_DOCUMENTATION.md                ← Vollständige Doku
├── API_QUICK_REFERENCE.md              ← Schnelle Übersicht
├── REST_API_SETUP.md                   ← Installation
├── INTEGRATION_EXAMPLES.md             ← Code-Beispiele
├── API_IMPLEMENTATION_SUMMARY.txt      ← Summary
├── DOCUMENTATION_OVERVIEW.md           ← Diese Datei
│
└── [weitere Dateien...]
```

---

## 🚀 Dokumentation anzeigen

### Im Code

Öffne einfach die API-Klassen:

- `Classes/Api/Product.php`
- `Classes/Api/Order.php`

Alle Methoden haben ausführliche Markdown-Dokumentation mit:
- Beschreibung
- Parameter
- Beispiele
- Response-Struktur
- Error-Beispiele

### Im TYPO3 Backend

Wenn nnrestapi konfiguriert ist, wird die Dokumentation automatisch:

1. **Geparsed** aus den PHP-Kommentaren
2. **Rendert** als HTML im Backend
3. **Angezeigt** im nnrestapi Modul

### Lokale Ansicht

Sieh dir die Markdown-Dateien direkt an:

```bash
cat NNRESTAPI_DOCUMENTATION_GUIDE.md
cat API_DOCUMENTATION.md
cat INTEGRATION_EXAMPLES.md
```

---

## 📖 Markdown Features in der Dokumentation

### Überschriften

```markdown
## Haupttitel
### Untertitel
#### Details
```

### Listen

```markdown
- Punkt 1
- Punkt 2
  - Unterpunkt

1. Schritt 1
2. Schritt 2
```

### Code-Blöcke

```markdown
```json
{
  "success": true,
  "data": {}
}
```

```php
// PHP Code
```

```
GET /api/product
```
```

### Tabellen

```markdown
| Code | Beschreibung |
|------|------------|
| 0 | Neu |
| 1 | Bestätigt |
```

### Formatierung

```markdown
**Fett**
*Kursiv*
`Code inline`
```

---

## ✨ Was ist dokumentiert?

### Product API (6 Endpoints)

| Endpoint | Beschreibung | Dokumentiert |
|----------|------------|---|
| GET /api/product | Alle Produkte | ✅ Mit Markdown |
| GET /api/product/{uid} | Einzelnes Produkt | ✅ Mit Markdown |
| GET /api/product/active | Aktive Produkte | ✅ Mit Markdown |
| GET /api/product/search | Nach Suchbegriff | ✅ Mit Markdown & Beispiel |
| GET /api/product/recent | Neueste Produkte | ✅ Mit Markdown |
| GET /api/product/sku | Nach SKU suchen | ✅ Mit Markdown & Error |

### Order API (7 Endpoints)

| Endpoint | Beschreibung | Dokumentiert |
|----------|------------|---|
| GET /api/order | Alle Bestellungen | ✅ Mit Markdown |
| GET /api/order/{uid} | Einzelne Bestellung | ✅ Mit Markdown |
| GET /api/order/number | Nach Bestellnummer | ✅ Mit Markdown & Beispiel |
| GET /api/order/email | Nach Kundenemails | ✅ Mit Markdown & Beispiel |
| GET /api/order/status | Nach Status | ✅ Mit Markdown & Status-Tabelle |
| GET /api/order/recent | Neueste Bestellungen | ✅ Mit Markdown |
| GET /api/order/user | Nach Benutzer | ✅ Mit Markdown & Beispiel |

---

## 🎓 Wie man neue Endpoints dokumentiert

### Schritt 1: Öffne die API-Klasse

```bash
vim packages/tuning_tool_shop/Classes/Api/Product.php
```

### Schritt 2: Schreibe einen Markdown-Kommentar

```php
/**
 * ## Mein neuer Endpoint
 *
 * Beschreibung des Endpoints.
 *
 * ### Parameter
 *
 * - **param1** (erforderlich): Beschreibung
 *
 * ### Examples
 *
 * #### Request
 *
 * ```
 * GET /api/product/myaction?param1=value
 * ```
 *
 * #### Response
 *
 * ```json
 * {
 *   "success": true,
 *   "data": {}
 * }
 * ```
 *
 * @Api\Route("/product/myaction")
 * @Api\Access("public")
 * @return array
 */
public function getMyactionAction(): array
{
    // Implementation...
}
```

### Schritt 3: Cache leeren

```bash
php vendor/bin/typo3 cache:flush
```

### Schritt 4: Dokumentation ansehen

- Im Backend (falls nnrestapi Modul aktiviert)
- In der PHP-Datei
- In der auto-generierten Dokumentation

---

## 💡 Best Practices

### ✅ Gute Dokumentation

```markdown
## Produkte nach Kategorie

Ruft alle aktiven Produkte einer Kategorie ab.
Produktoptionen werden mit geladen.

### Parameter

- **category** (erforderlich): Die Kategorie-ID (integer)

### Examples

#### Request

```
GET /api/product/category?category=5
```

#### Response

```json
{
  "success": true,
  "data": [
    {
      "uid": 1,
      "title": "Product",
      "category": 5
    }
  ],
  "count": 10
}
```

### Fehler

Wenn die Kategorie nicht gefunden wird:

```json
{
  "success": false,
  "message": "Category not found"
}
```
```

### ❌ Schlechte Dokumentation

```php
/**
 * Get products by category
 */
public function getCategoryAction() {}
```

---

## 📚 Dokumentations-Referenzen

### nnrestapi Dokumentation

- [nnrestapi Docs](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html)
- [Writing Documentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/WritingDoc/Index.html)
- [Examples](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/Examples/Index.html)

### Markdown Guide

- [Markdown Cheat Sheet](https://www.markdownguide.org/cheat-sheet/)
- [GitHub Flavored Markdown](https://github.github.com/gfm/)

---

## 🔍 Debugging

### Syntax überprüfen

```bash
php -l Classes/Api/Product.php
php -l Classes/Api/Order.php
```

### Markdown validieren

Überprüfe die Markdown-Syntax in den Kommentaren mit einem Markdown Linter.

### Cache-Probleme

Falls die Dokumentation nicht aktualisiert wird:

```bash
php vendor/bin/typo3 cache:flush
```

### Im Backend ansehen

1. Gehe zu Admin Tools
2. Suche nach nnrestapi Modul
3. Die Dokumentation sollte dort angezeigt werden

---

## 📝 Checkliste für neue Endpoints

- [ ] Markdown-Kommentar geschrieben
- [ ] Titel mit ## 
- [ ] Beschreibung hinzugefügt
- [ ] Parameter dokumentiert
- [ ] Beispiele mit Request/Response
- [ ] Error-Beispiele (falls relevant)
- [ ] @Api\Route() Annotation
- [ ] @Api\Access() Annotation
- [ ] @return type Annotation
- [ ] Syntax mit `php -l` überprüft
- [ ] Cache geleert

---

## 🎉 Die Dokumentation ist fertig!

**Alle 13 REST API Endpoints sind jetzt dokumentiert im nnrestapi-Stil:**

- ✅ Product API mit 6 Endpoints
- ✅ Order API mit 7 Endpoints
- ✅ Markdown-Dokumentation in den PHP-Dateien
- ✅ Umfassende externe Dokumentation
- ✅ Code-Beispiele für mehrere Sprachen
- ✅ Best Practices Guide

**Starte mit dem Lesen von:**
1. `NNRESTAPI_DOCUMENTATION_GUIDE.md` - Guide zur Dokumentation
2. `Classes/Api/Product.php` - Produktendpoints
3. `Classes/Api/Order.php` - Bestellungsendpoints
4. `API_DOCUMENTATION.md` - Vollständige Dokumentation
5. `INTEGRATION_EXAMPLES.md` - Code-Beispiele

---

**Dokumentation im nnrestapi-Stil ✨**
