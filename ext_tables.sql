#
# Table structure for table 'tx_tuningtoolshop_domain_model_category'
#
CREATE TABLE tx_tuningtoolshop_domain_model_category (
    title varchar(255) NOT NULL DEFAULT '',
    slug varchar(2048) NOT NULL DEFAULT '',
    description text,
    image int unsigned NOT NULL DEFAULT 0,
    parent int unsigned NOT NULL DEFAULT 0
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_manufacturer'
#
CREATE TABLE tx_tuningtoolshop_domain_model_manufacturer (
    title varchar(255) NOT NULL DEFAULT '',
    slug varchar(2048) NOT NULL DEFAULT '',
    logo int unsigned NOT NULL DEFAULT 0,
    description text,
    website varchar(255) NOT NULL DEFAULT ''
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_product'
#
CREATE TABLE tx_tuningtoolshop_domain_model_product (
    title varchar(255) NOT NULL DEFAULT '',
    slug varchar(2048) NOT NULL DEFAULT '',
    sku varchar(100) NOT NULL DEFAULT '',
    price decimal(10,2) NOT NULL DEFAULT 0.00,
    special_price decimal(10,2) NOT NULL DEFAULT 0.00,
    description text,
    short_description text,
    headline varchar(255) NOT NULL DEFAULT '',
    manufacturer int unsigned NOT NULL DEFAULT 0,
    categories int unsigned NOT NULL DEFAULT 0,
    images int unsigned NOT NULL DEFAULT 0,
    videos int unsigned NOT NULL DEFAULT 0,
    documents int unsigned NOT NULL DEFAULT 0,
    links int unsigned NOT NULL DEFAULT 0,
    stock int NOT NULL DEFAULT 0,
    weight decimal(10,3) NOT NULL DEFAULT 0.000,
    is_active tinyint(1) unsigned NOT NULL DEFAULT 1,
    tax int unsigned NOT NULL DEFAULT 0,
    shipping_methods int unsigned NOT NULL DEFAULT 0
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_shippingmethod'
#
CREATE TABLE tx_tuningtoolshop_domain_model_shippingmethod (
    title varchar(255) NOT NULL DEFAULT '',
    description text,
    provider varchar(255) NOT NULL DEFAULT '',
    logo int unsigned NOT NULL DEFAULT 0,
    price decimal(10,2) NOT NULL DEFAULT 0.00,
    is_active tinyint(1) unsigned NOT NULL DEFAULT 1,
    sort_order int NOT NULL DEFAULT 0
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_paymentmethod'
#
CREATE TABLE tx_tuningtoolshop_domain_model_paymentmethod (
    title varchar(255) NOT NULL DEFAULT '',
    description text,
    icon int unsigned NOT NULL DEFAULT 0,
    is_active tinyint(1) unsigned NOT NULL DEFAULT 1,
    sort_order int NOT NULL DEFAULT 0,
    handler_class varchar(255) NOT NULL DEFAULT ''
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_order'
#
CREATE TABLE tx_tuningtoolshop_domain_model_order (
    order_number varchar(50) NOT NULL DEFAULT '',
    transaction_id varchar(255) NOT NULL DEFAULT '',
    customer_email varchar(255) NOT NULL DEFAULT '',
    customer_name varchar(255) NOT NULL DEFAULT '',
    customer_first_name varchar(255) NOT NULL DEFAULT '',
    customer_last_name varchar(255) NOT NULL DEFAULT '',
    customer_company varchar(255) NOT NULL DEFAULT '',
    billing_address text,
    billing_street varchar(255) NOT NULL DEFAULT '',
    billing_zip varchar(20) NOT NULL DEFAULT '',
    billing_city varchar(255) NOT NULL DEFAULT '',
    billing_country varchar(2) NOT NULL DEFAULT '',
    shipping_address text,
    shipping_first_name varchar(255) NOT NULL DEFAULT '',
    shipping_last_name varchar(255) NOT NULL DEFAULT '',
    shipping_company varchar(255) NOT NULL DEFAULT '',
    shipping_street varchar(255) NOT NULL DEFAULT '',
    shipping_zip varchar(20) NOT NULL DEFAULT '',
    shipping_city varchar(255) NOT NULL DEFAULT '',
    shipping_country varchar(2) NOT NULL DEFAULT '',
    shipping_same_as_billing tinyint(1) unsigned NOT NULL DEFAULT 1,
    comment text,
    subtotal decimal(10,2) NOT NULL DEFAULT 0.00,
    discount decimal(10,2) NOT NULL DEFAULT 0.00,
    shipping_cost decimal(10,2) NOT NULL DEFAULT 0.00,
    payment_method int unsigned NOT NULL DEFAULT 0,
    shipping_method int unsigned NOT NULL DEFAULT 0,
    status int NOT NULL DEFAULT 0,
    payment_status int NOT NULL DEFAULT 0,
    total decimal(10,2) NOT NULL DEFAULT 0.00,
    items_json text,
    notes text,
    created_at int unsigned NOT NULL DEFAULT 0
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_cartitem'
#
CREATE TABLE tx_tuningtoolshop_domain_model_cartitem (
    fe_user int unsigned NOT NULL DEFAULT 0,
    session_id varchar(255) NOT NULL DEFAULT '',
    product int unsigned NOT NULL DEFAULT 0,
    quantity int NOT NULL DEFAULT 1
);

#
# Table structure for table 'tx_tuningtoolshop_domain_model_tax'
#
CREATE TABLE tx_tuningtoolshop_domain_model_tax (
    title varchar(255) NOT NULL DEFAULT '',
    rate decimal(5,2) NOT NULL DEFAULT 19.00,
    country varchar(2) NOT NULL DEFAULT 'DE',
    is_default tinyint(1) unsigned NOT NULL DEFAULT 0
);

#
# Table structure for table 'tx_tuningtoolshop_product_category_mm'
#
CREATE TABLE tx_tuningtoolshop_product_category_mm (
    uid_local int unsigned NOT NULL DEFAULT 0,
    uid_foreign int unsigned NOT NULL DEFAULT 0,
    sorting int unsigned NOT NULL DEFAULT 0,
    sorting_foreign int unsigned NOT NULL DEFAULT 0,

    PRIMARY KEY (uid_local,uid_foreign),
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_tuningtoolshop_product_shippingmethod_mm'
#
CREATE TABLE tx_tuningtoolshop_product_shippingmethod_mm (
    uid_local int unsigned NOT NULL DEFAULT 0,
    uid_foreign int unsigned NOT NULL DEFAULT 0,
    sorting int unsigned NOT NULL DEFAULT 0,
    sorting_foreign int unsigned NOT NULL DEFAULT 0,

    PRIMARY KEY (uid_local,uid_foreign),
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);
