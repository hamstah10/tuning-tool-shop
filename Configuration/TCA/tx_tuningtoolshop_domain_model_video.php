<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'title,description,video_url',
        'iconfile' => 'EXT:tuning_tool_shop/Resources/Public/Icons/tuning-icon.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l10n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_video',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_video}.{#pid}=###CURRENT_PID### AND {#tx_tuningtoolshop_domain_model_video}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
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
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video.title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'file' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video.file',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types',
                'maxitems' => 1,
            ],
        ],
        'video_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video.video_url',
            'description' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_video.video_url.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 2048,
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title,
                    description,
                    file,
                    video_url,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
            ',
        ],
    ],
    'palettes' => [
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
    ],
];
