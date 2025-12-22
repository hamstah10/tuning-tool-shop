<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productlink',
        'label' => 'title',
        'label_alt' => 'url',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tuning_tool_shop/Resources/Public/Icons/tuning-icon.svg',
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
        'product' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productlink.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required',
            ],
        ],
        'url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_productlink.url',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 2048,
                'eval' => 'trim,required',
                'softref' => 'typolink_tag,url',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                title,
                url,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,
            ',
        ],
    ],
];
