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
                 'type' => 'inline',
                 'foreign_table' => 'tx_tuningtoolshop_domain_model_productdeliveryscope',
                 'foreign_field' => 'lieferumfang',
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
                'type' => 'inline',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_video',
                'foreign_field' => 'product',
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
        'documents' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.documents',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_download',
                'foreign_field' => 'product',
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
        'shipping_free' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.shipping_free',
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
        'product_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.product_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.product_type.normal', 'value' => 'normal'],
                    ['label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.product_type.starter', 'value' => 'starter'],
                ],
                'default' => 'normal',
            ],
        ],
        'operating_costs' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.operating_costs',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'extensions' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.extensions',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'startup_help_headline' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.startup_help_headline',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'startup_help_text' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.startup_help_text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'features_headline' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.features_headline',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'features_text' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.features_text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'recommendation_headline' => [
            'exclude' => true,
            'displayCond' => 'FIELD:product_type:=:starter',
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.recommendation_headline',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'recommendation_text' => [
             'exclude' => true,
             'displayCond' => 'FIELD:product_type:=:starter',
             'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.recommendation_text',
             'config' => [
                 'type' => 'text',
                 'enableRichtext' => true,
                 'cols' => 40,
                 'rows' => 5,
             ],
         ],
        'meta_title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.meta_title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'meta_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.meta_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'meta_keywords' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.meta_keywords',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'canonical_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.canonical_url',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 2048,
                'eval' => 'trim',
            ],
        ],
        'related_products' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.related_products',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_product',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_product}.{#uid} != ###THIS_UID### AND {#tx_tuningtoolshop_domain_model_product}.{#sys_language_uid} IN (-1,0) ORDER BY tx_tuningtoolshop_domain_model_product.title',
                'MM' => 'tx_tuningtoolshop_product_relatedproducts_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
            ],
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tx_tuningtoolshop_domain_model_product.tags',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_tuningtoolshop_domain_model_tag',
                'foreign_table_where' => 'AND {#tx_tuningtoolshop_domain_model_tag}.{#sys_language_uid} IN (-1,0) ORDER BY tx_tuningtoolshop_domain_model_tag.title',
                'MM' => 'tx_tuningtoolshop_product_tag_mm',
                'size' => 5,
                'autoSizeMax' => 20,
                'maxitems' => 9999,
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
                     product_type,
                     short_description,
                      description,
                      lieferumfang,
                 --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.seo,
                     meta_title,
                     meta_description,
                     meta_keywords,
                     canonical_url,
                 --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.starter_package,
                    operating_costs,
                    extensions,
                    startup_help_headline,
                    startup_help_text,
                    features_headline,
                    features_text,
                    recommendation_headline,
                    recommendation_text,
                    --div--;LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:tabs.relations,
                    manufacturer,
                    categories,
                    tags,
                    related_products,
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
            'showitem' => 'stock, weight, is_active, shipping_free',
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
