<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Dashboard;

use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class InventoryWidget implements WidgetInterface
{
    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly ProductRepository $productRepository,
    ) {}

    public function renderWidgetContent(): string
    {
        $GLOBALS['LANG'] = $GLOBALS['LANG'] ?? new LanguageService();
        $view = new StandaloneView();
        $view->setTemplateRootPaths([
            'EXT:tuning_tool_shop/Resources/Private/Templates/Backend',
        ]);
        $view->setTemplate('Dashboard/InventoryWidget');

        // Ignoriere Storage Page für Dashboard Widget
        $allProducts = $this->productRepository->findAllIgnoreStorage();
        $lowStockProducts = [];
        $totalStock = 0;
        $productsCount = 0;

        foreach ($allProducts as $product) {
            $productsCount++;
            $stock = $product->getStock();
            $totalStock += $stock;

            if ($stock <= 10) {
                $lowStockProducts[] = $product;
            }
        }

        // Sortiere low stock Produkte nach Bestand
        usort($lowStockProducts, static function($a, $b) {
            return $a->getStock() <=> $b->getStock();
        });

        // Limit auf 15 Produkte
        $lowStockProducts = array_slice($lowStockProducts, 0, 15);

        $view->assignMultiple([
            'totalStock' => $totalStock,
            'productsCount' => $productsCount,
            'lowStockProducts' => $lowStockProducts,
        ]);

        return $view->render();
    }

    public function getTitle(): string
    {
        return 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang.xlf:dashboard.inventory.title';
    }

    public function getDescription(): string
    {
        return 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang.xlf:dashboard.inventory.description';
    }

    public function getIdentifier(): string
    {
        return 'tuning_tool_shop_inventory';
    }

    public function getIconIdentifier(): string
    {
        return 'content-widget-list';
    }

    public function getOptions(): array
    {
        return [];
    }
}
