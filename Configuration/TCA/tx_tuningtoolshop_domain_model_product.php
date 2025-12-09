<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product',
        'label' => 'title',
        'label_alt' => 'sku',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,sku,description,short_description,headline',
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
                'foreign_table' => 'tx_tuningtoolshop_domain_model_product',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_product}.{#pid}=###CURRENT_PID### AND {#tx_tuningtoolshop_domain_model_product}.{#sys_language_uid} IN (-1,0)',
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
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.slug',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '-',
                    'prefixParentPageSlug' => false,
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'sku' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.sku',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 100,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.price',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
                'required' => true,
            ],
        ],
        'special_price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.special_price',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 10,
            ],
        ],
        'short_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.short_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'headline' => [
             'exclude' => true,
             'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.headline',
             'config' => [
                 'type' => 'input',
                 'size' => 50,
                 'max' => 255,
                 'eval' => 'trim',
             ],
         ],
         'lieferumfang' => [
             'exclude' => true,
             'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.lieferumfang',
             'config' => [
                 'type' => 'text',
                 'enableRichtext' => true,
                 'cols' => 40,
                 'rows' => 5,
             ],
         ],
         'manufacturer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.manufacturer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.manufacturer.none', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_manufacturer',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_manufacturer}.{#sys_language_uid} IN (-1,0) ORDER BY tx_tuningtoolshop_domain_model_manufacturer.title',
                'default' => 0,
            ],
        ],
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_category',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_category}.{#sys_language_uid} IN (-1,0) ORDER BY tx_tuningtoolshop_domain_model_category.title',
                'MM' => 'tx_tuningtoolshop_product_category_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
            ],
        ],
        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.images',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 99,
                'overrideChildTca' => [
                    'types' => [
                        \TYPO3\CMS\Core\Resource\FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette
                            ',
                        ],
                    ],
                ],
            ],
        ],
        'videos' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.videos',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types',
                'maxitems' => 10,
            ],
        ],
        'documents' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.documents',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-text-types',
                'maxitems' => 20,
            ],
        ],
        'links' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.links',
            'description' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.links.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'stock' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.stock',
            'config' => [
                'type' => 'number',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'weight' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.weight',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.is_active',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                    ],
                ],
                'default' => 1,
            ],
        ],
        'tax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.tax',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.tax.none', 'value' => 0],
                ],
                'foreign_table' => 'tx_tuningtoolshop_domain_model_tax',
                'foreign_table_where' => 'ORDER BY tx_tuningtoolshop_domain_model_tax.title',
                'default' => 0,
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;sku_headline,
                    --palette--;;prices,
                    short_description,
                     description,
                     lieferumfang,
                    --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.relations,
                    manufacturer,
                    categories,
                    --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.media,
                    images,
                    videos,
                    documents,
                    links,
                --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.inventory,
                    --palette--;;inventory,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access,
            ',
        ],
    ],
    'palettes' => [
        'general' => [
            'showitem' => 'title, slug',
        ],
        'sku_headline' => [
            'showitem' => 'sku, headline',
        ],
        'prices' => [
            'showitem' => 'price, special_price, tax',
        ],
        'inventory' => [
            'showitem' => 'stock, weight, is_active',
        ],
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
        'hidden' => [
            'showitem' => 'hidden',
        ],
        'access' => [
            'showitem' => 'starttime, endtime',
        ],
    ],
];
