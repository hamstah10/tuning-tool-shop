# Shop Admin Panel - Frontend Verwaltung

Ein Frontend Plugin zur Verwaltung von Produkten, Kategorien und Herstellern.

## Installation

1. Das Plugin ist bereits in der Extension `tuning_tool_shop` enthalten
2. Clear TYPO3 Caches:
   ```bash
   php vendor/bin/typo3 cache:flush
   ```

## Setup

### 1. Erstelle eine neue Seite für die Admin-Panel

- Gehe zu: Backend → Seiten
- Erstelle eine neue Seite (z.B. "Shop Administration")
- Merke dir die Seiten-ID

### 2. Füge das Plugin hinzu

1. Bearbeite die neue Seite
2. Gehe zum Tab "Inhalte"
3. Füge einen neuen Content hinzu ("+")
4. Wähle Plugin → "Shop: Administration"
5. Speichern

### 3. Konfiguriere Zugriffsbeschränkungen (optional)

Das Plugin ist nur für angemeldete Frontend-Nutzer zugänglich. Um nur bestimmte Nutzer Zugriff zu geben:

1. Erstelle eine Frontend-Benutzergruppe "Shop Admins"
2. Füge den Nutzern die Gruppe zu
3. Das Plugin prüft automatisch auf angemeldete Nutzer

## Features

### Dashboard
- Übersicht über Produkte, Kategorien und Hersteller
- Schnelle Links zu allen Verwaltungsfunktionen

### Produktverwaltung
- **Liste**: Alle Produkte anzeigen
- **Neu**: Neues Produkt erstellen
- **Bearbeiten**: Produktdetails bearbeiten:
  - Titel, SKU, Preise
  - Lagerbestand, Gewicht
  - Kurzbeschreibung & Beschreibung
  - Hersteller & Kategorien
  - Versandkostenfrei-Flag
  - Aktiv/Inaktiv Status

- **Löschen**: Produkt entfernen

### Kategorieverwaltung
- **Liste**: Alle Kategorien anzeigen
- **Neu**: Neue Kategorie erstellen
- **Bearbeiten**: 
  - Name
  - Beschreibung
  - Übergeordnete Kategorie (für Hierarchien)
- **Löschen**: Kategorie entfernen

### Herstellerverwaltung
- **Liste**: Alle Hersteller anzeigen
- **Neu**: Neuer Hersteller erstellen
- **Bearbeiten**:
  - Name
  - Website-URL
  - Beschreibung
- **Löschen**: Hersteller entfernen

## URL-Struktur

Das Plugin nutzt Extbase und generiert URLs wie:

```
/admin/dashboard/
/admin/list-products/
/admin/new-product/
/admin/edit-product/{uid}/
/admin/list-categories/
/admin/new-category/
/admin/edit-category/{uid}/
/admin/list-manufacturers/
/admin/new-manufacturer/
/admin/edit-manufacturer/{uid}/
```

## Sicherheit

### Authentifizierung
Das Plugin ist automatisch auf Frontend-Nutzer beschränkt:
```php
protected function getCurrentFrontendUser()
{
    return $GLOBALS['TSFE']->fe_user->user ?? null;
}
```

Nicht angemeldete Nutzer werden auf die Dashboard-Seite weitergeleitet.

### Best Practice für Produktionsumgebungen

1. Erstelle eine spezielle Benutzergruppe "Shop Admins"
2. Beschränke die Admin-Seite auf diese Gruppe (via TYPO3 Access Control)
3. Nutze HTTPS für alle Admin-Operationen
4. Regelmäßige Backups vor größeren Änderungen

## Fehlerbehandlung

Das Plugin hat integrierte Fehlerbehandlung:
- Flashmessages für erfolgreiche Operationen
- Error-Logging in `var/log/typo3_*.log`
- Validierung von Eingaben

Beispiel-Fehlermeldungen:
- ✓ "Produkt erfolgreich gespeichert."
- ✗ "Fehler beim Speichern des Produkts."

## Logging

Fehler werden in den Systemlogs geloggt:
```
var/log/typo3_YYYYMMDD_HHMM_HASH.log
```

Zu suchende Fehler:
```
Error saving product:
Error saving category:
Error saving manufacturer:
Error deleting product:
```

## Erweiterungen

Das Plugin kann erweitert werden um:

1. **Bilder-Upload**
   - Requires: `FileRepository`
   - Zielort: `fileadmin/shop/products/`

2. **Bulk-Operationen**
   - Mehrere Produkte auf einmal bearbeiten
   - CSV Import/Export

3. **Audit-Logging**
   - Wer hat was wann geändert
   - Änderungshistorie

4. **Versioning**
   - Entwürfe speichern
   - Revisions-Vergleich

## Template-Anpassung

Die Templates befinden sich in:
```
packages/tuning_tool_shop/Resources/Private/Templates/Admin/
```

Layout wird verwendet:
```
packages/tuning_tool_shop/Resources/Private/Layouts/Default.html
```

### CSS anpassen

CSS ist inline in jedem Template. Für gemeinsame Styles erstelle:
```
packages/tuning_tool_shop/Resources/Public/Css/admin.css
```

Und included es im Layout.

## Troubleshooting

### Plugin wird nicht angezeigt
1. Cache leeren: `php vendor/bin/typo3 cache:flush`
2. Extension installiert? Check via Backend → Extensions
3. Richtige Seite? Muss "Content" haben (nicht Sysfolder)

### Speichern funktioniert nicht
1. Fehler im Log? Check `var/log/`
2. Datenbankrechte? Nutzer braucht CREATE/UPDATE/DELETE
3. Content-Sicherheit? CSRF-Token sollte automatisch sein

### Eingeloggter Nutzer sieht Panel nicht
1. Frontend-Nutzer erstellt? Backend → Admin Tools
2. Nutzer aktiv? Check "Disabled" Flag
3. Usergroup-Restrictions auf Seite? Via Seiten-Properties

## API für Entwickler

### In einem eigenen Plugin verwenden

```php
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;

public function __construct(
    protected readonly ProductRepository $productRepository,
) {}

public function someAction()
{
    $products = $this->productRepository->findAll();
}
```

### Ereignisse/Hooks

Aktuell keine Hook-Points. Können hinzugefügt werden via:

```php
$this->eventDispatcher->dispatch(
    new ModifyProductEvent($product)
);
```

## Performance

- Alle Queries nutzen Standard-Repositories
- Lazy-Loading für Relationen
- Pagination möglich (aktuell nicht implementiert)
- Cache-Busting nach Saves (automatisch via Extbase)

## Browser-Unterstützung

- Chrome/Firefox/Safari (modern)
- IE11 NICHT unterstützt
- Mobile-responsive Design

## Kontakt & Support

Bei Fragen oder Bugs: Backend-Administrator kontaktieren.
