# Manuelle Datenbank-Migration für tuning_tool_shop

Bitte führen Sie folgende SQL-Befehle in der Datenbank aus:

```sql
-- Verbinden Sie sich mit der Datenbank
USE tfd_hamstahstudio;

-- Spalte für Frontend-Benutzer hinzufügen
ALTER TABLE tx_tuningtoolshop_domain_model_order 
ADD COLUMN IF NOT EXISTS frontend_user_id INT(11) DEFAULT 0 AFTER uid;

-- Spalte für MwSt.-Betrag hinzufügen
ALTER TABLE tx_tuningtoolshop_domain_model_order 
ADD COLUMN IF NOT EXISTS tax_amount DECIMAL(11,2) DEFAULT 0.00 AFTER subtotal;

-- Index auf frontend_user_id hinzufügen für bessere Performance
ALTER TABLE tx_tuningtoolshop_domain_model_order 
ADD INDEX idx_frontend_user_id (frontend_user_id);

-- Verifizierung
DESCRIBE tx_tuningtoolshop_domain_model_order;
```

Nachdem diese Befehle ausgeführt wurden, sollte das Orders-Plugin funktionieren.

Um die Spalten in phpMyAdmin hinzuzufügen:
1. Öffnen Sie phpMyAdmin
2. Gehen Sie zur Datenbank "tfd_hamstahstudio"
3. Wählen Sie die Tabelle "tx_tuningtoolshop_domain_model_order"
4. Klicken Sie auf "Struktur"
5. Klicken Sie auf "Spalte hinzufügen"
6. Fügen Sie zwei neue Spalten hinzu:
   - frontend_user_id: INT(11) NULL DEFAULT 0
   - tax_amount: DECIMAL(11,2) NULL DEFAULT 0.00
