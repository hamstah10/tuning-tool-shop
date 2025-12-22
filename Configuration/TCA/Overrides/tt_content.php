<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// ProductList Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'ProductList',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productlist.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/ProductList.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_productlist'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_productlist',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/ProductList.xml'
);

// ProductDetail Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'ProductDetail',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productdetail.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/ProductDetail.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

// ProductSlider Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'ProductSlider',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productslider.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_productslider'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_productslider',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/ProductSlider.xml'
);

// Cart Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Cart',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.cart.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Cart.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_cart'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_cart',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Cart.xml'
);

// Checkout Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Checkout',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.checkout.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Checkout.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_checkout'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_checkout',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Checkout.xml'
);

// Orders Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Orders',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.orders.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_orders'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_orders',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Orders.xml'
);

// SelectedProducts Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'SelectedProducts',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.selectedproducts.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/SelectedProducts.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tuningtoolshop_selectedproducts'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'tuningtoolshop_selectedproducts',
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/SelectedProducts.xml'
);

// Tags Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Tags',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.tags.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

// CategoryMenu Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'CategoryMenu',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.categorymenu.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

// ManufacturerMenu Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'ManufacturerMenu',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.manufacturermenu.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);

// Admin Plugin
ExtensionUtility::registerPlugin(
    'tuning_tool_shop',
    'Admin',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_fe.xlf:plugin.admin.title',
    'EXT:tuning_tool_shop/Resources/Public/Icons/Extension.svg',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin_group.tuning-tool-shop'
);
