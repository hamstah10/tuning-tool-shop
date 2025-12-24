# Shop Admin Plugin - TCA Registrierung

## Update durchgeführt

Das Admin Plugin wurde vollständig in die TCA-Struktur der tuning_tool_shop Extension registriert.

### Änderungen

#### 1. TCA/Overrides/tt_content.php
**Update**: Admin Plugin Registrierung hinzugefügt

```php
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Admin',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.admin.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);
```

**Effect**: Admin Plugin wird jetzt in der Backend Content-Element Auswahl unter der Gruppe **"tuning-tool-shop"** (Shop) angezeigt.

#### 2. locallang_db.xlf
**Update**: Sprachlabel hinzugefügt

```xml
<trans-unit id="plugin.admin.title" resname="plugin.admin.title">
    <source>Shop: Administration</source>
</trans-unit>
<trans-unit id="plugin.admin.description" resname="plugin.admin.description">
    <source>Frontend-Administration für Produkte, Kategorien und Hersteller</source>
</trans-unit>
```

**Effect**: Korrekte Anzeige im Backend mit Titel und Beschreibung.

### Wie es funktioniert

1. **Backend öffnen** → **Seiten**
2. **Neue Seite erstellen** oder **bestehende öffnen**
3. **Tab "Inhalte"**
4. **"+" klicken** → Neues Content-Element
5. **Typ: Plugin** wählen
6. **Jetzt ist die "Shop" Kategorie sichtbar** mit:
   - Shop: Produktliste
   - Shop: Produktdetails
   - Shop: Produktslider
   - Shop: Warenkorb
   - Shop: Checkout
   - Shop: Meine Bestellungen
   - Shop: Tags
   - Shop: Kategorien-Menü
   - Shop: Hersteller-Menü
   - **Shop: Administration** ← NEU!

### Registrierungsmechanismus

TYPO3 nutzt `ExtensionUtility::registerPlugin()` mit Parametern:

```php
registerPlugin(
    extensionName: 'tuning_tool_shop',    // Extension Key
    pluginName: 'Admin',                   // Plugin Identifier
    pluginTitle: '...',                    // Label
    pluginIcon: '...',                     // Icon Path
    pluginCategory: '...'                  // Kategorie/Gruppe
);
```

Der 5. Parameter bestimmt, unter welcher Gruppe das Plugin angezeigt wird.

### Verfügbare Gruppen in tuning_tool_shop

Alle 10 Plugins nutzen die gleiche Gruppe:
```
plugin_group.tuning-tool-shop
```

Das Label wird in `locallang_db.xlf` definiert:
```xml
<trans-unit id="plugin_group.tuning-tool-shop" resname="plugin_group.tuning-tool-shop">
    <source>Shop</source>
</trans-unit>
```

### Zusammenfassung

| Plugin | Registriert | Gruppiert |
|--------|------------|-----------|
| ProductList | ✓ | Shop |
| ProductDetail | ✓ | Shop |
| ProductSlider | ✓ | Shop |
| Cart | ✓ | Shop |
| Checkout | ✓ | Shop |
| Orders | ✓ | Shop |
| SelectedProducts | ✓ | Shop |
| Tags | ✓ | Shop |
| CategoryMenu | ✓ | Shop |
| ManufacturerMenu | ✓ | Shop |
| **Admin** | **✓** | **Shop** |

---

**Status**: ✅ Plugin ist vollständig in der Shop-Kategorie registriert!
