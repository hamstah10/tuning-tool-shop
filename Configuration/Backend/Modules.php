<?php

declare(strict_types=1);

use Hamstahstudio\TuningToolShop\Controller\BackendController;

return [
    'tuning_tool_shop' => [
        'parent' => 'web',
        'position' => ['after' => 'web_list'],
        'access' => 'user',
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
