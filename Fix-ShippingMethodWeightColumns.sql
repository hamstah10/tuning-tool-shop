-- Fix duplicate and incorrect weight columns in shipping method table
-- This script removes camelCase columns and ensures snake_case columns exist

-- Drop incorrect camelCase columns if they exist
ALTER TABLE tx_tuningtoolshop_domain_model_shippingmethod 
DROP COLUMN IF EXISTS minWeight;

ALTER TABLE tx_tuningtoolshop_domain_model_shippingmethod 
DROP COLUMN IF EXISTS maxWeight;

-- Add min_weight column if it doesn't exist
ALTER TABLE tx_tuningtoolshop_domain_model_shippingmethod 
ADD COLUMN IF NOT EXISTS min_weight decimal(10,2) NOT NULL DEFAULT 0.00 AFTER price;

-- Modify max_weight column to ensure correct format
ALTER TABLE tx_tuningtoolshop_domain_model_shippingmethod 
MODIFY COLUMN max_weight decimal(10,2) NOT NULL DEFAULT 0.00;

-- Verify the table structure
-- Should have: price, min_weight, max_weight (all decimal(10,2))
