ALTER TABLE tx_tuningtoolshop_domain_model_order ADD COLUMN IF NOT EXISTS frontend_user_id INT(11) DEFAULT 0;
ALTER TABLE tx_tuningtoolshop_domain_model_order ADD COLUMN IF NOT EXISTS tax_amount DECIMAL(11,2) DEFAULT 0.00;
