<?php

declare(strict_types=1);

use Hamstahstudio\TuningToolShop\Controller\ProductController;
use Hamstahstudio\TuningToolShop\Controller\CartController;
use Hamstahstudio\TuningToolShop\Controller\CheckoutController;
use Hamstahstudio\TuningToolShop\Controller\StripeController;
use Hamstahstudio\TuningToolShop\Controller\PaymentController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addTypoScriptSetup('
plugin.tx_tuningtoolshop {
    view {
        templateRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Templates/
        partialRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Partials/
        layoutRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Layouts/
    }
    persistence {
        storagePid =
    }
}
');

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'ProductList',
    [
        ProductController::class => 'list,category,manufacturer,search',
    ],
    [
        ProductController::class => 'list,search',
    ]
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'SelectedProducts',
    [
        ProductController::class => 'selected',
    ],
    []
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'ProductDetail',
    [
        ProductController::class => 'show',
    ],
    []
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'Cart',
    [
        CartController::class => 'index,add,update,remove',
    ],
    [
        CartController::class => 'add,update,remove',
    ]
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'Checkout',
    [
        CheckoutController::class => 'index,process,confirmation',
    ],
    [
        CheckoutController::class => 'process',
    ]
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'Payment',
    [
        PaymentController::class => 'redirect,success,cancel,notify',
    ],
    [
        PaymentController::class => 'redirect,success,cancel,notify',
    ]
);

ExtensionUtility::configurePlugin(
    'TuningToolShop',
    'Stripe',
    [
        StripeController::class => 'createPaymentIntent,success,cancel,webhook',
    ],
    [
        StripeController::class => 'createPaymentIntent,success,cancel,webhook',
    ]
);

// Register dashboard widget groups
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dashboard']['widgetGroups'] = array_merge(
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dashboard']['widgetGroups'] ?? [],
    require ExtensionManagementUtility::extPath('tuning_tool_shop') . 'Configuration/Backend/DashboardWidgetGroups.php'
);


