# Konfigurierbare Produkte - Handbuch

## Überblick

Mit konfigurierbaren Produkten können Kunden beim Kauf verschiedene Optionen auswählen. Beispiel: Eine Flex Slave Box mit verschiedenen Optionen.

## Produktarten

Im Backend gibt es folgende Produkttypen:
- **Normal**: Einfaches Produkt ohne Optionen
- **Konfigurierbares Produkt**: Produkt mit Optionen (z.B. Speicher, Farbe, Ausstattung)
- **Digitales Produkt**: Herunterladbare Produkte (z.B. PDF, Software)
- **Starter Paket**: Spezielle Starter-Pakete mit erweiterten Feldern

## Konfigurierbare Produkte erstellen

### Schritt 1: Produkt anlegen
1. Gehen Sie ins Backend → Shop → Produkte
2. Klicken Sie "Neues Produkt hinzufügen"
3. Füllen Sie die Basis-Informationen aus:
   - **Titel**: z.B. "Flex Slave Box"
   - **Artikelnummer (SKU)**: z.B. "FSB-1090"
   - **Preis**: 1090.00 EUR
   - **Produkttyp**: Wählen Sie **"Konfigurierbares Produkt"**

### Schritt 2: Produktoptionen hinzufügen
Nach dem Speichern mit Produkttyp "Konfigurierbares Produkt" erscheint der Reiter **"Optionen"**.

Klicken Sie dort auf "Neue Option hinzufügen" und konfigurieren Sie jede Option:

**Option 1: Speicher**
- **Optionsname**: "Speicher"
- **Eingabetyp**: "Dropdown (Select)"
- **Erforderlich**: ✓ (Haken setzen)
- **Optionswerte**:
  - 512 MB | Preismodifikator: 0.00 EUR
  - 1 GB | Preismodifikator: +50.00 EUR
  - 2 GB | Preismodifikator: +100.00 EUR

**Option 2: Farbe**
- **Optionsname**: "Farbe"
- **Eingabetyp**: "Radiobuttons"
- **Erforderlich**: ✓
- **Optionswerte**:
  - Schwarz | Preismodifikator: 0.00 EUR
  - Silber | Preismodifikator: +25.00 EUR
  - Weiß | Preismodifikator: 0.00 EUR

**Option 3: Zusatzgarantie**
- **Optionsname**: "Zusatzgarantie"
- **Eingabetyp**: "Checkboxen"
- **Erforderlich**: ✗ (nicht erforderlich)
- **Optionswerte**:
  - 2 Jahre Garantie | Preismodifikator: +150.00 EUR

## Eingabetypen

### Select (Dropdown)
- Kunde kann nur eine Option auswählen
- Ideal für: Speicher, Größe, Farbe

### Checkbox
- Kunde kann mehrere Optionen auswählen
- Ideal für: Zusatzleistungen, Zubehör, Garantien

### Radio (Radiobuttons)
- Kunde kann nur eine Option auswählen (wie Select, aber als Buttons sichtbar)
- Ideal für: Versandart, Lieferformat

## Preismodifikator

Der Preismodifikator wird zum Basispreis addiert:
- **0.00 EUR**: Standard-Option ohne Aufpreis
- **+50.00 EUR**: Option kostet 50 EUR mehr
- **-20.00 EUR**: Option kostet 20 EUR weniger

Beispiel:
- Basispreis: 1090.00 EUR
- Speicher 1GB (+50): → 1140.00 EUR
- Farbe Silber (+25): → 1165.00 EUR
- Gesamtpreis mit allen Optionen: 1165.00 EUR

## Datenbankstruktur

### tx_tuningtoolshop_domain_model_product
- `product_type` = "configurable"

### tx_tuningtoolshop_domain_model_productoption
- `title`: Optionsname (z.B. "Speicher")
- `type`: select|checkbox|radio
- `is_required`: Ob die Option erforderlich ist (0|1)
- `product`: Referenz zum Produkt
- `sorting`: Sortierreihenfolge

### tx_tuningtoolshop_domain_model_productoptionvalue
- `title`: Optionswert (z.B. "512 MB")
- `price_modifier`: Preisaufschlag
- `product_option`: Referenz zur Option
- `sorting`: Sortierreihenfolge

## Frontend-Verwendung

Im Produkt-Detail-Template können Sie auf die Optionen zugreifen:

```fluid
<f:if condition="{product.productType} == 'configurable'">
    <div class="product-options">
        <f:for each="{product.options}" as="option">
            <div class="option-group">
                <label>{option.title} <f:if condition="{option.isRequired}"><span class="required">*</span></f:if></label>
                
                <f:if condition="{option.type} == 'select'">
                    <select name="option[{option.uid}]" <f:if condition="{option.isRequired}">required</f:if>>
                        <option value="">-- Bitte wählen --</option>
                        <f:for each="{option.values}" as="value">
                            <option value="{value.uid}" data-price="{value.priceModifier}">
                                {value.title} <f:if condition="{value.priceModifier}"> (+{value.priceModifier} EUR)</f:if>
                            </option>
                        </f:for>
                    </select>
                </f:if>
                
                <f:if condition="{option.type} == 'checkbox'">
                    <f:for each="{option.values}" as="value">
                        <div>
                            <input type="checkbox" name="option[{option.uid}][]" value="{value.uid}" id="opt-{value.uid}">
                            <label for="opt-{value.uid}">
                                {value.title} <f:if condition="{value.priceModifier}">(+{value.priceModifier} EUR)</f:if>
                            </label>
                        </div>
                    </f:for>
                </f:if>
                
                <f:if condition="{option.type} == 'radio'">
                    <f:for each="{option.values}" as="value">
                        <div>
                            <input type="radio" name="option[{option.uid}]" value="{value.uid}" id="opt-{value.uid}" <f:if condition="{option.isRequired}">required</f:if>>
                            <label for="opt-{value.uid}">
                                {value.title} <f:if condition="{value.priceModifier}">(+{value.priceModifier} EUR)</f:if>
                            </label>
                        </div>
                    </f:for>
                </f:if>
            </div>
        </f:for>
    </div>
</f:if>
```

## PHP-Verwendung in Controllern

```php
<?php

$product = $this->productRepository->findByUid($productId);

// Optionen abrufen
$options = $product->getOptions();

foreach ($options as $option) {
    echo $option->getTitle(); // "Speicher"
    echo $option->getType();  // "select"
    echo $option->getIsRequired(); // true/false
    
    foreach ($option->getValues() as $value) {
        echo $value->getTitle(); // "512 MB"
        echo $value->getPriceModifier(); // 0.00
    }
}
```

## Preis-Berechnung im Warenkorb

Beim Hinzufügen zum Warenkorb muss der finale Preis berechnet werden:

```php
$finalPrice = $product->getPrice();

// Optionspreise addieren
if (!empty($_POST['options'])) {
    foreach ($_POST['options'] as $optionId => $selectedValues) {
        $option = $this->productOptionRepository->findByUid((int)$optionId);
        
        if (is_array($selectedValues)) {
            // Checkbox: mehrere Werte
            foreach ($selectedValues as $valueId) {
                $value = $this->productOptionValueRepository->findByUid((int)$valueId);
                $finalPrice += $value->getPriceModifier();
            }
        } else {
            // Select/Radio: ein Wert
            $value = $this->productOptionValueRepository->findByUid((int)$selectedValues);
            $finalPrice += $value->getPriceModifier();
        }
    }
}
```

## Weitere Hinweise

- Optionen können nur bei Produkttyp "Konfigurierbares Produkt" hinzugefügt werden
- Die Sortierung der Optionen und Optionswerte kann per Drag & Drop angepasst werden
- Preismodifikatoren können auch negativ sein (z.B. für Rabatte)
- Erforderliche Optionen sollten in der Frontend-Validierung überprüft werden
