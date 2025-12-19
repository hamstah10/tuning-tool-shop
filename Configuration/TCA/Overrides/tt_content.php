<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'ProductList',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productlist.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_productlist';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/ProductList.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'SelectedProducts',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.selectedproducts.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_selectedproducts';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/SelectedProducts.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'ProductDetail',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productdetail.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_productdetail';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/ProductDetail.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'Cart',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.cart.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_cart';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Cart.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'Checkout',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.checkout.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_checkout';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Checkout.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'Orders',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.orders.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_orders';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Orders.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'Tags',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.tags.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_tags';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Tags.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'CategoryMenu',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.categorymenu.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_categorymenu';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/CategoryMenu.xml'
);

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'ManufacturerMenu',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.manufacturermenu.title',
    'mimetypes-x-content-domain-content'
);

$pluginSignature = 'tuningtoolshop_manufacturermenu';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/ManufacturerMenu.xml'
);

