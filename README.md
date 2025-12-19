# Tuning Tool Shop

TYPO3 13 Shop Extension für Chiptuning Geräte und Zubehör mit vollständiger E-Commerce-Funktionalität.

## Features

### Produktverwaltung
- **Produktkatalog**: Umfassende Produktdatenbank mit SKU, Beschreibung, Preis, Spezialpreis
- **Kategorien & Hersteller**: Flexible Kategorisierung und Herstellerverwaltung
- **Produktbilder**: Multi-Image Support mit Fluid-Verarbeitung
- **Videos & Dokumente**: Integration von Videos und Download-Dokumenten
- **Produkttypen**: Normale Produkte, Downloadware, etc.
- **Lieferumfang**: Definierbare Lieferumfangsoptionen
- **Lagerbestand**: Lagerverwaltung mit Verfügbarkeitsprüfung
- **Gewichte & Versand**: Gewichtsangaben für Versandberechnung
- **Verwandte Produkte**: Cross-Selling durch verwandte Produkte
- **Tags**: Flexible Tagging für verbesserte Filterung

### Produktdarstellung
- **Mehrere Templates**: Grid, Grid mit Typ, Kompakte Liste, Detailliert, Countdown
- **Flexible Ansichtsoptionen**:
  - Anzahl Items pro Seite (einstellbar)
  - Grid-Spalten (3 oder 4)
  - Produktpreis anzeigen/verbergen
  - Produktbeschreibung anzeigen/verbergen
  - Produktbild anzeigen/verbergen
  - "In den Warenkorb" Button anzeigen/verbergen
- **Sortieroptionen**: Nach Name (A-Z, Z-A), Preis (aufsteigend/absteigend), Erstellungsdatum
- **Filterung**:
  - Nach Kategorie
  - Nach Hersteller
  - Frontend-Filter mit Formular
  - Backend-Filter (vordefiniert pro Plugin)

### Listing Features
- **Pagination**: Seitenwechsel mit benutzerdefinierten Items pro Seite
- **URL-Integration**: SEO-freundliche URLs über Route Enhancers
- **Kategorieseiten**: Dedizierte Kategorieseiten mit Produktübersicht
- **Herstellerseiten**: Hersteller-Detailseiten mit deren Produkten
- **Tag-Seiten**: Tag-basierte Produktsammlung
- **Suche**: Volltextsuche über Produkttitel und Beschreibung
- **Countdown-Ansicht**: Special Sale Ansicht mit Countdown-Timer

### Warenkorb
- **Mini-Warenkorb**: Schwebende Warenkorbanzeige im Header
- **Warenkorb-Seite**: Detaillierte Warenkorbverwaltung
- **Mengen-Management**: Hinzufügen, Bearbeiten, Löschen von Produkten
- **Preis-Berechnung**:
  - Zwischensumme (Netto)
  - Steuern (konfigurierbar pro Produkt)
  - Versandkosten
  - Gesamtsumme (Brutto)
- **Persistierung**: Warenkorb in der Session/Datenbank

### Checkout & Bestellung
- **One-Page Checkout**: Vereinfachter Bestellprozess auf einer Seite
- **Kundendaten**:
  - Rechnungsadresse
  - Lieferadresse
  - E-Mail-Bestätigung
- **Versandoptionen**: Auswahl aus konfigurierten Versandmethoden
- **Gewichtsbasierte Versandberechnung**: Automatische Berechnung basierend auf Produktgewicht
- **Versandmethoden**: Verschiedene Versandarten mit unterschiedlichen Kosten
- **Zahlungsmethoden**: 
  - Vorkasse
  - Nachnahme
  - PayPal
  - Stripe/Kreditkarte
  - Klarna
- **Bestellbearbeitung**: 
  - Bestelldetails speichern
  - Bestätigungsemail
  - Bestellhistorie für Kunden

### Zahlungsintegration
- **Stripe Integration**:
  - Kreditkarten-Zahlung (Visa, Mastercard, etc.)
  - Webhook-Unterstützung
  - Sichere Zahlungsabwicklung
  - Fehlerbehandlung
- **PayPal Integration**:
  - PayPal Express Checkout
  - Standard Zahlungsoptionen
  - Webhook-Verarbeitung
  - Order-Synchronisierung
- **Klarna Integration**:
  - Buy now, pay later (BNPL)
  - Ratenkauf
  - Sichere Zahlungsabwicklung
- **Vorkasse & Nachnahme**: Manuelle Zahlungsmethoden

### Bestellverwaltung
- **Kundenbestellübersicht**: Alle Bestellungen im Frontend sichtbar
- **Bestelldetails**: Einzelbestellansicht mit:
  - Bestellnummer
  - Bestelldatum
  - Bestellstatus
  - Positionen & Preise
  - Zahlungsstatus
  - Versandstatus
- **Bestellverlauf**: Chronologische Übersicht aller Bestellungen
- **Download-Verwaltung**: Automatische Downloads für digitale Produkte

### Produkteigenschaften
- **Steuern**: Konfigurierbare Steuersätze pro Produkt
- **Spezialpreis**: Verkaufspreisermäßigung mit automatischer Berechnung
- **Aktivierungsstatus**: Sichtbarkeit von Produkten steuern
- **Metadaten**: 
  - Meta Title für SEO
  - Meta Description
  - Meta Keywords
  - Canonical URL
- **Rich Content**:
  - Startup-Hilfe (Überschrift + Text)
  - Features (Überschrift + Text)
  - Empfehlungen (Überschrift + Text)
  - Rich HTML Editor Support

### Admin-Features
- **Backend-Module**: Verwaltungsmodul für Shop-Einstellungen
- **Plugin-Konfiguration** (FlexForm):
  - Separate Konfiguration pro Plugin (ProductList, Cart, Checkout, etc.)
  - Template-Auswahl
  - Filtereinstellungen
  - Seiten-Links (Detail-, Warenkorb-, Checkout-Seite)
  - Anzahl Items
  - Sortieroptionen
- **Datenbankmanagement**: SQL-Updates für Migration und Setup

### SEO & Performance
- **URL-Rewriting**: Freundliche URLs durch Route Enhancers
- **Slug-Support**: Automatische Slug-Generierung für Kategorien, Hersteller, Produkte
- **Pagination URL**: SEO-freundliche Seitennummerierung (z.B. `/produkte/2`)
- **Responsive Design**: Bootstrap-basiertes Responsive Design

### Datenschutz & Sicherheit
- **Frontend User Integration**: Benutzer-Registration & Login
- **Benutzergruppen**: Rollenbasierte Zugriffskontrolle möglich
- **Session-Management**: Sichere Warenkorb-Sessions
- **TYPO3 Security**: Verwendung von TYPO3 Security Best Practices

## Anforderungen

- PHP >= 8.2
- TYPO3 >= 13.4
- Doctrine/Extbase ORM
- Bootstrap Package (für Templates)

## Installation

```bash
composer require hamstahstudio/tuning-tool-shop
composer exec typo3 setup --no-interaction
```

## Plugins

### ProductList
Zeigt eine filterable und sortierbare Produktliste mit verschiedenen Layout-Optionen.

**Controller-Action**: `Product::list`

**Konfigurierbare Einstellungen**:
- Items pro Seite
- Template-Auswahl (default, compact, detailed, countdown)
- Grid-Spalten
- Sortieroption
- Sortierrichtung
- Kategorie- und Herstellerfilter (Backend)
- Detail- und Warenkorb-Seite Link

### ProductDetail
Zeigt Produktdetails mit Bildern, Videos, Dokumenten und "In den Warenkorb"-Button.

**Controller-Action**: `Product::show`

### Cart
Warenkorb-Ansicht mit Mengenänderung, Produktentfernung und Checkout-Link.

**Controller-Action**: `Cart::index`, `Cart::add`, `Cart::update`, `Cart::remove`

**Funktionen**:
- Warenkorb anzeigen
- Produkte hinzufügen
- Mengen ändern
- Produkte entfernen
- Versandkosten berechnen
- Gesamtpreis mit Steuern

### Checkout
One-Page Checkout mit Adresseingabe, Versand- und Zahlungswahl, Bestellplatzierung.

**Controller-Action**: `Checkout::index`, `Checkout::process`, `Checkout::confirmation`

**Schritte**:
1. Kundenadresse
2. Versandmethode wählen
3. Zahlungsmethode wählen
4. Bestellung bestätigen

### Orders
Kundenbestellhistorie mit Detailseiten.

**Controller-Action**: `Orders::list`, `Orders::detail`

### Payment
Zahlungs-Gateway Handler (PayPal, Stripe, Klarna, etc.)

**Controller-Action**: `Payment::*`, `Stripe::*`

### CategoryMenu
Navigationskomponente für Produktkategorien.

**Controller-Action**: `Category::*`

### ManufacturerMenu
Navigationskomponente für Hersteller.

**Controller-Action**: `Manufacturer::*`

### TagsPlugin
Tag-basierte Produktfilterung und -anzeige.

**Controller-Action**: `Tag::*`

### SelectedProducts
Zeigt handverlesene Produkte basierend auf UIDs.

**Controller-Action**: `Product::selected`

## Domänenmodelle

### Product
Hauptprodukt-Entity mit allen Produktinformationen.

### Category
Produktkategorie mit Slug und Hierarchie.

### Manufacturer
Hersteller von Produkten.

### ShippingMethod
Versandart mit Gewichtsabhängigen Kosten.

### PaymentMethod
Zahlungsmethoden (Vorkasse, PayPal, Stripe, Klarna, etc.)

### Order & OrderItem
Bestellverwaltung mit Positionen und Status.

### Cart & CartItem
Warenkorb im Session gespeichert.

### Tax
Steuersätze für Produkte.

### Video, Download
Zusätzliche Produktmaterialien.

### ProductDeliveryScope
Lieferumfang-Optionen.

### Tag
Flexible Produkt-Tags.

## Tipps & Best Practices

- **Sprachverwaltung**: Alle Frontend-Labels sind mehrsprachig in `locallang_fe.xlf`
- **Backend-Labels**: Admin-Labels in `locallang_be.xlf`
- **Route Enhancers**: Für SEO-freundliche URLs in `config/sites/*/config.yaml`
- **TypoScript**: Zusätzliche Konfiguration möglich in `Configuration/TypoScript/`
- **Migrations**: Alte Updates in `Updates/` für Schema-Änderungen

## Entwicklung

Der Shop-Code folgt PSR-12 Standard und nutzt Constructor Injection für alle Dependencies.

```bash
# Installation lokal
cd packages/tuning_tool_shop && composer install

# Testing (wenn aktiviert)
composer exec phpunit

# Code-Stil
composer exec php-cs-fixer fix
```

## Support & Dokumentation

Zusätzliche Dokumentation:
- `PAYPAL_SETUP_GUIDE.md` - PayPal Integration Anleitung
- `KLARNA_SETUP_GUIDE.md` - Klarna Integration Anleitung
- `STRIPE_INTEGRATION.md` - Stripe Integration
- `CHECKOUT-SETUP.md` - Checkout Konfiguration
- `IMPLEMENTATION_CHECKLIST.md` - Implementierungs-Checkliste

## Lizenz

Diese Extension ist unter der Lizenz des Projekts lizenziert.
