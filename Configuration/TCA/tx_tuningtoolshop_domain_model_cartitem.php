<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem',
        'label' => 'product',
        'label_alt' => 'quantity',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'default_sortby' => 'crdate DESC',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'session_id',
        'iconfile' => 'EXT:tuning_tool_shop/Resources/Public/Icons/tx_tuningtoolshop_domain_model_cartitem.svg',
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
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem.fe_user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem.fe_user.guest', 'value' => 0],
                ],
                'foreign_table' => 'fe_users',
                'foreign_table_where' => 'ORDER BY fe_users.username',
                'default' => 0,
            ],
        ],
        'session_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem.session_id',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'product' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem.product',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_product',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_product}.{#is_active} = 1 AND {#tx_tuningtoolshop_domain_model_product}.{#sys_language_uid} IN (-1,0) ORDER BY tx_tuningtoolshop_domain_model_product.title',
                'default' => 0,
                'required' => true,
            ],
        ],
        'quantity' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_cartitem.quantity',
            'config' => [
                'type' => 'number',
                'size' => 5,
                'default' => 1,
                'range' => [
                    'lower' => 1,
                    'upper' => 9999,
                ],
                'required' => true,
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;user_session,
                    product,
                    quantity,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
            ',
        ],
    ],
    'palettes' => [
        'user_session' => [
            'showitem' => 'fe_user, session_id',
        ],
        'hidden' => [
            'showitem' => 'hidden',
        ],
    ],
];
