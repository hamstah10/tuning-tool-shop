# 🚀 Shop Admin Panel - Quick Start

Starte das Frontend Shop Admin Panel in 5 Minuten!

## Schritt 1: Cache leeren (1 Minute)

```bash
php vendor/bin/typo3 cache:flush
```

## Schritt 2: Admin-Seite im Backend erstellen (2 Minuten)

1. **Backend öffnen** → Seiten
2. **Neue Seite** anlegen:
   - Titel: "Shop Administration"
   - Slug: "shop-admin"
   - Merke dir die Seiten-ID (z.B. 123)
3. **Speichern**

## Schritt 3: Plugin hinzufügen (1 Minute)

1. Seite öffnen → Tab **"Inhalte"**
2. **"+"** klicken
3. **Plugin** wählen
4. **"Shop: Administration"** suchen und wählen
5. **Speichern**

## Schritt 4: Frontend-User erstellen (1 Minute)

1. Backend → Admin Tools → **Frontend Users**
2. **Neu** klicken
3. Ausfüllen:
   - Username: `admin` (oder gewünscht)
   - Password: sicheres Passwort
   - Email: `admin@example.com`
4. Checkbox **"Disabled"** = **NICHT ANGEHAKT** lassen!
5. **Speichern & Schließen**

## Schritt 5: Testen im Frontend (0 Minuten)

1. **Frontend öffnen** → Admin-Seite
2. Oben rechts: **"Login"** (falls vorhanden)
3. Username & Password eingeben
4. Anmelden
5. **Dashboard sollte sichtbar sein!** ✓

---

## Was Sie jetzt tun können

### Produkte verwalten
```
Admin-Panel → Produkte
```
- ✏️ **Neue Produkte** erstellen
- ✏️ **Produkte** bearbeiten
- 🗑️ **Produkte** löschen
- Preise, Lagerbestände, Beschreibungen ändern

### Kategorien verwalten
```
Admin-Panel → Kategorien
```
- ✏️ **Neue Kategorien** erstellen
- ✏️ **Kategorien** bearbeiten (auch Hierarchien!)
- 🗑️ **Kategorien** löschen

### Hersteller verwalten
```
Admin-Panel → Hersteller
```
- ✏️ **Neue Hersteller** erstellen
- ✏️ **Hersteller** bearbeiten
- 🗑️ **Hersteller** löschen

---

## Häufige Fehler

### ❌ "Plugin wird nicht angezeigt"
- Cache leeren: `php vendor/bin/typo3 cache:flush`
- Seite refreshen
- Cookies löschen

### ❌ "Zugriff verweigert"
- Frontend-User angemeldet? Prüfe oben rechts
- "Disabled" Flag bei User = NICHT angehakt?
- Cookies aktiviert?

### ❌ "Speichern funktioniert nicht"
- Fehler in Log? `var/log/typo3_*.log`
- Pflichtfelder gefüllt? (mit * gekennzeichnet)
- JavaScript Fehler? F12 → Console

---

## URLs

Wenn Seite ID = 123:

```
/shop-admin/                           Dashboard
/shop-admin/admin/list-products        Produktliste
/shop-admin/admin/new-product          Neues Produkt
/shop-admin/admin/edit-product/42      Produkt 42 bearbeiten
/shop-admin/admin/list-categories      Kategorieliste
/shop-admin/admin/list-manufacturers   Herstellerliste
```

---

## Tipps & Tricks

### 💡 Formularvalidierung
- Pflichtfelder müssen ausgefüllt sein (*)
- Preise nur Zahlen
- URLs müssen mit http:// oder https:// beginnen

### 💡 Bestätigungsdialoge
- Löschen fragt nach: "Wirklich löschen?"
- Abbrechen = Seite wird NICHT aktualisiert

### 💡 Flash-Messages
- Grüne Messages = Erfolgreich ✓
- Rote Messages = Fehler ✗

### 💡 Performance
- Seite lädt langsam? Cache leeren
- Viele Produkte (>1000)? Backend nutzen

---

## Sicherheit

⚠️ **Wichtig für Production:**

1. **HTTPS verwenden** (Admin-Seite nur über HTTPS)
2. **Starke Passwörter** (12+ Zeichen, Sonderzeichen)
3. **Regelmäßige Backups** vor größeren Änderungen
4. **Admin-URL schützen** (z.B. IP-Whitelisting)
5. **Audit-Logging** (optional in Backend aktivieren)

---

## Support

**Fehler gefunden?**

Schau in das Log:
```bash
tail -f var/log/typo3_*.log
```

Suche nach "Error" oder "Admin" Zeilen.

---

**Fertig!** 🎉 Viel Spaß mit dem Admin Panel!
