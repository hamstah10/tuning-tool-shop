<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'TuningToolShop',
    'ProductList',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productlist.title',
    'tuning-tool-shop-productlist'
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
    'ProductDetail',
    'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_db.xlf:plugin.productdetail.title',
    'tuning-tool-shop-productdetail'
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
    'tuning-tool-shop-cart'
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
    'tuning-tool-shop-checkout'
);

$pluginSignature = 'tuningtoolshop_checkout';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tuning_tool_shop/Configuration/FlexForms/Checkout.xml'
);


