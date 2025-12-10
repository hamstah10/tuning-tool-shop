<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Dashboard;

use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class OrdersWidget implements WidgetInterface
{
    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly OrderRepository $orderRepository,
    ) {}

    public function renderWidgetContent(): string
    {
        try {
            $GLOBALS['LANG'] = $GLOBALS['LANG'] ?? new LanguageService();
            $view = new StandaloneView();
            $view->setTemplateRootPaths([
                'EXT:tuning_tool_shop/Resources/Private/Templates/Backend',
            ]);
            $view->setTemplate('Dashboard/OrdersWidget');
            
            $recentOrders = $this->orderRepository->findRecent(10);
            $totalRevenue = $this->calculateTotalRevenue();
            $pendingOrders = $this->orderRepository->findByStatus(0);
            
            $view->assignMultiple([
                'recentOrders' => $recentOrders,
                'totalRevenue' => $totalRevenue,
                'pendingOrders' => $pendingOrders,
            ]);

            return $view->render();
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }

    private function calculateTotalRevenue(): float
    {
        try {
            $orders = $this->orderRepository->findAll();
            $total = 0.0;

            foreach ($orders as $order) {
                if ($order->getPaymentStatus() === 1) {
                    $total += $order->getTotal();
                }
            }

            return $total;
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    public function getTitle(): string
    {
        return 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang.xlf:dashboard.orders.title';
    }

    public function getDescription(): string
    {
        return 'LLL:EXT:tuning_tool_shop/Resources/Private/Language/locallang.xlf:dashboard.orders.description';
    }

    public function getIdentifier(): string
    {
        return 'tuning_tool_shop_orders';
    }

    public function getIconIdentifier(): string
    {
        return 'content-widget-table';
    }

    public function getOptions(): array
    {
        return [];
    }
}
