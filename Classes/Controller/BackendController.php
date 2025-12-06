<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ManufacturerRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\PaymentMethodRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class BackendController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ManufacturerRepository $manufacturerRepository,
        protected readonly OrderRepository $orderRepository,
        protected readonly CartItemRepository $cartItemRepository,
        protected readonly PaymentMethodRepository $paymentMethodRepository,
        protected readonly PersistenceManager $persistenceManager,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    ) {}

    public function indexAction(): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        $productCount = $this->productRepository->countAll();
        $categoryCount = $this->categoryRepository->countAll();
        $manufacturerCount = $this->manufacturerRepository->countAll();
        $orderCount = $this->orderRepository->countAll();

        $recentOrders = $this->orderRepository->findRecent(10);
        $newOrdersCount = $this->orderRepository->countByStatus(Order::STATUS_NEW);
        $processingOrdersCount = $this->orderRepository->countByStatus(Order::STATUS_PENDING);

        $moduleTemplate->assignMultiple([
            'productCount' => $productCount,
            'categoryCount' => $categoryCount,
            'manufacturerCount' => $manufacturerCount,
            'orderCount' => $orderCount,
            'recentOrders' => $recentOrders,
            'newOrdersCount' => $newOrdersCount,
            'processingOrdersCount' => $processingOrdersCount,
        ]);

        return $moduleTemplate->renderResponse('Backend/Index');
    }

    public function ordersAction(): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        $orders = $this->orderRepository->findAll();

        $moduleTemplate->assign('orders', $orders);

        return $moduleTemplate->renderResponse('Backend/Orders');
    }

    public function orderDetailAction(Order $order): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        $moduleTemplate->assign('order', $order);

        return $moduleTemplate->renderResponse('Backend/OrderDetail');
    }

    public function updateOrderStatusAction(Order $order, int $status): ResponseInterface
    {
        $order->setStatus($status);
        $this->orderRepository->update($order);
        $this->persistenceManager->persistAll();

        $this->addFlashMessage('Bestellstatus wurde aktualisiert.');

        return $this->redirect('orderDetail', null, null, ['order' => $order->getUid()]);
    }
}
