<?php

declare(strict_types=1);

use Hamstahstudio\TuningToolShop\Controller\AdminController;

return [
    'tuning_tool_shop_admin' => [
        'vendor' => 'TuningToolShop',
        'label' => 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang_fe.xlf:plugin.admin.title',
        'group' => 'shop',
        'extensionName' => 'TuningToolShop',
        'pluginType' => 'list_type',
        'pluginName' => 'Admin',
        'controllerActions' => [
            AdminController::class => [
                'dashboard',
                'listProducts',
                'newProduct',
                'editProduct',
                'saveProduct',
                'deleteProduct',
                'listCategories',
                'newCategory',
                'editCategory',
                'saveCategory',
                'deleteCategory',
                'listManufacturers',
                'newManufacturer',
                'editManufacturer',
                'saveManufacturer',
                'deleteManufacturer',
            ],
        ],
        'signature' => 'tuning_tool_shop_admin',
    ],
];
