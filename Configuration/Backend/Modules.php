<?php

declare(strict_types=1);

use Hamstahstudio\TuningToolShop\Controller\BackendController;

return [
    'tuningfuxtools' => [
        'labels' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_mod.xlf:module_plugin',
        'iconIdentifier' => 'tuningfux-module',
        'navigationComponent' => '@typo3/backend/tree/page-tree-element',
        'extensionName' => 'TuningToolShop',
    ],
    'tuning_tool_shop' => [
        'parent' => 'tuningfuxtools',
        
        'access' => 'user,admin',
        'workspaces' => 'live',
        'iconIdentifier' => 'tuning-tool-shop-module',
        'path' => '/module/web/tuning-tool-shop',
        'labels' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_mod.xlf',
        'extensionName' => 'TuningToolShop',
        'controllerActions' => [
            BackendController::class => [
                'index',
                'orders',
                'orderDetail',
                'updateOrderStatus',
            ],
        ],
    ],
];
