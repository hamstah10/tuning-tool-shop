<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order',
        'label' => 'order_number',
        'label_alt' => 'customer_first_name,customer_last_name,customer_email',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'default_sortby' => 'created_at DESC',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'order_number,customer_email,customer_first_name,customer_last_name',
        'iconfile' => 'EXT:tuning_tool_shop/Resources/Public/Icons/tx_tuningtoolshop_domain_model_order.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'order_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.order_number',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 50,
                'eval' => 'trim',
                'required' => true,
                'readOnly' => true,
            ],
        ],
        'transaction_id' => [
            'exclude' => true,
            'label' => 'Transaktions-ID',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'customer_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.customer_email',
            'config' => [
                'type' => 'email',
                'size' => 30,
                'required' => true,
            ],
        ],
        'customer_first_name' => [
            'exclude' => true,
            'label' => 'Vorname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'customer_last_name' => [
            'exclude' => true,
            'label' => 'Nachname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'customer_company' => [
            'exclude' => true,
            'label' => 'Firma',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'billing_street' => [
            'exclude' => true,
            'label' => 'Straße',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'billing_zip' => [
            'exclude' => true,
            'label' => 'PLZ',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 20,
                'eval' => 'trim',
            ],
        ],
        'billing_city' => [
            'exclude' => true,
            'label' => 'Ort',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'billing_country' => [
            'exclude' => true,
            'label' => 'Land',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 2,
                'eval' => 'trim',
            ],
        ],
        'shipping_same_as_billing' => [
            'exclude' => true,
            'label' => 'Lieferadresse = Rechnungsadresse',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'shipping_first_name' => [
            'exclude' => true,
            'label' => 'Lieferung: Vorname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'shipping_last_name' => [
            'exclude' => true,
            'label' => 'Lieferung: Nachname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'shipping_company' => [
            'exclude' => true,
            'label' => 'Lieferung: Firma',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'shipping_street' => [
            'exclude' => true,
            'label' => 'Lieferung: Straße',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'shipping_zip' => [
            'exclude' => true,
            'label' => 'Lieferung: PLZ',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 20,
                'eval' => 'trim',
            ],
        ],
        'shipping_city' => [
            'exclude' => true,
            'label' => 'Lieferung: Ort',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'shipping_country' => [
            'exclude' => true,
            'label' => 'Lieferung: Land',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 2,
                'eval' => 'trim',
            ],
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'Kundenkommentar',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'subtotal' => [
            'exclude' => true,
            'label' => 'Zwischensumme',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'discount' => [
            'exclude' => true,
            'label' => 'Rabatt',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'shipping_cost' => [
            'exclude' => true,
            'label' => 'Versandkosten',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'payment_method' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.payment_method',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Keine', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_paymentmethod',
                'foreign_table_where' => 'ORDER BY tx_tuningtoolshop_domain_model_paymentmethod.sort_order',
                'default' => 0,
            ],
        ],
        'shipping_method' => [
            'exclude' => true,
            'label' => 'Versandart',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Keine', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_shippingmethod',
                'foreign_table_where' => 'ORDER BY tx_tuningtoolshop_domain_model_shippingmethod.sort_order',
                'default' => 0,
            ],
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Neu', 'value' => 0],
                    ['label' => 'In Bearbeitung', 'value' => 1],
                    ['label' => 'Bestätigt', 'value' => 2],
                    ['label' => 'Versendet', 'value' => 3],
                    ['label' => 'Abgeschlossen', 'value' => 4],
                    ['label' => 'Storniert', 'value' => 5],
                ],
                'default' => 0,
            ],
        ],
        'payment_status' => [
            'exclude' => true,
            'label' => 'Zahlungsstatus',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Ausstehend', 'value' => 0],
                    ['label' => 'Bezahlt', 'value' => 1],
                    ['label' => 'Fehlgeschlagen', 'value' => 2],
                    ['label' => 'Erstattet', 'value' => 3],
                ],
                'default' => 0,
            ],
        ],
        'total' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.total',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'items_json' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.items_json',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 10,
                'readOnly' => true,
            ],
        ],
        'notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.notes',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_order.created_at',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'readOnly' => true,
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;Bestellung,
                    --palette--;;order_info,
                --div--;Kunde,
                    --palette--;;customer_name,
                    customer_email,
                    customer_company,
                --div--;Rechnungsadresse,
                    billing_street,
                    --palette--;;billing_location,
                --div--;Lieferadresse,
                    shipping_same_as_billing,
                    --palette--;;shipping_name,
                    shipping_company,
                    shipping_street,
                    --palette--;;shipping_location,
                --div--;Zahlung & Versand,
                    payment_method,
                    shipping_method,
                    --palette--;;costs,
                    --palette--;;status,
                --div--;Artikel,
                    items_json,
                --div--;Notizen,
                    comment,
                    notes,
                --div--;Zugang,
                    hidden,
            ',
        ],
    ],
    'palettes' => [
        'order_info' => [
            'showitem' => 'order_number, created_at, transaction_id',
        ],
        'customer_name' => [
            'showitem' => 'customer_first_name, customer_last_name',
        ],
        'billing_location' => [
            'showitem' => 'billing_zip, billing_city, billing_country',
        ],
        'shipping_name' => [
            'showitem' => 'shipping_first_name, shipping_last_name',
        ],
        'shipping_location' => [
            'showitem' => 'shipping_zip, shipping_city, shipping_country',
        ],
        'costs' => [
            'showitem' => 'subtotal, shipping_cost, discount, total',
        ],
        'status' => [
            'showitem' => 'status, payment_status',
        ],
    ],
];
