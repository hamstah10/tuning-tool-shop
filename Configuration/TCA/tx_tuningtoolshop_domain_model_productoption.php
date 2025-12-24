<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tuning_tool_shop/Resources/Public/Icons/tuning-icon.svg',
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
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required',
            ],
        ],
        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.type.select', 'value' => 'select'],
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.type.checkbox', 'value' => 'checkbox'],
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.type.radio', 'value' => 'radio'],
                ],
                'default' => 'select',
            ],
        ],
        'is_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.is_required',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'values' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productoption.values',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_productoptionvalue',
                'foreign_field' => 'product_option',
                'maxitems' => 999,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => false,
                    'useSortable' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'bottom',
                ],
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                title,
                type,
                is_required,
                values,
                hidden,
            ',
        ],
    ],
];
