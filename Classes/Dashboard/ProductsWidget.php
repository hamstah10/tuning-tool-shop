<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Dashboard;

use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ProductsWidget implements WidgetInterface
{
    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly ProductRepository $productRepository,
    ) {}

    public function renderWidgetContent(): string
    {
        $view = new StandaloneView();
        $view->setTemplateRootPaths([
            'EXT:tuning_tool_shop/Resources/Private/Templates/Backend',
        ]);
        $view->setTemplate('Dashboard/ProductsWidget');

        $view->assignMultiple([
            'title' => $this->configuration->getTitle(),
            'options' => $this->configuration->getOptions(),
            'totalProducts' => $this->productRepository->findAll()->count(),
            'recentProducts' => $this->productRepository->findRecent(5),
        ]);

        return $view->render();
    }

    public function getOptions(): array
    {
        return [];
    }
}
