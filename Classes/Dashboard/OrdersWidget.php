<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Dashboard;

use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
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
        $view = new StandaloneView();
        $view->setTemplateRootPaths([
            'EXT:tuning_tool_shop/Resources/Private/Templates/Backend',
        ]);
        $view->setTemplate('Dashboard/OrdersWidget');
        $view->assignMultiple([
            'title' => $this->configuration->getTitle(),
            'options' => $this->configuration->getOptions(),
            'recentOrders' => $this->orderRepository->findRecent(10),
            'totalRevenue' => $this->calculateTotalRevenue(),
            'pendingOrders' => $this->orderRepository->findByStatus(0),
        ]);

        return $view->render();
    }

    private function calculateTotalRevenue(): float
    {
        $orders = $this->orderRepository->findAll();
        $total = 0.0;

        foreach ($orders as $order) {
            if ($order->getPaymentStatus() === 1) {
                $total += $order->getTotal();
            }
        }

        return $total;
    }

    public function getOptions(): array
    {
        return [];
    }
}
