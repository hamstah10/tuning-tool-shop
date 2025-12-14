-- Create PayPal Payment Method
INSERT INTO tx_tuningtoolshop_domain_model_paymentmethod (
    pid, tstamp, crdate, deleted, hidden, 
    title, description, is_active, sort_order, handler_class
) VALUES (
    56, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0, 0,
    'PayPal', 'Bezahlen Sie sicher mit PayPal', 1, 1,
    'Hamstahstudio\\TuningToolShop\\Payment\\PayPalPaymentHandler'
) ON DUPLICATE KEY UPDATE 
    title=VALUES(title),
    handler_class=VALUES(handler_class);

-- Create Stripe Payment Method
INSERT INTO tx_tuningtoolshop_domain_model_paymentmethod (
    pid, tstamp, crdate, deleted, hidden, 
    title, description, is_active, sort_order, handler_class
) VALUES (
    56, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0, 0,
    'Kreditkarte (Stripe)', 'Bezahlen Sie mit Visa, Mastercard oder anderen Karten', 1, 2,
    'Hamstahstudio\\TuningToolShop\\Payment\\StripePaymentHandler'
) ON DUPLICATE KEY UPDATE 
    title=VALUES(title),
    handler_class=VALUES(handler_class);

-- Create Klarna Payment Method  
INSERT INTO tx_tuningtoolshop_domain_model_paymentmethod (
    pid, tstamp, crdate, deleted, hidden, 
    title, description, is_active, sort_order, handler_class
) VALUES (
    56, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0, 1,
    'Klarna', 'Bezahlen Sie später mit Klarna', 0, 3,
    'Hamstahstudio\\TuningToolShop\\Payment\\KlarnaPaymentHandler'
) ON DUPLICATE KEY UPDATE 
    title=VALUES(title),
    handler_class=VALUES(handler_class);
