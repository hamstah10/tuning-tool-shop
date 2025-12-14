-- Add min_weight column to shipping methods table
ALTER TABLE tx_tuningtoolshop_domain_model_shippingmethod 
ADD COLUMN min_weight decimal(10,2) NOT NULL DEFAULT 0 AFTER price;
