<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Service\AuthenticationService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class OrdersController extends ActionController
{
    public function __construct(
        protected readonly OrderRepository $orderRepository,
        protected readonly AuthenticationService $authenticationService,
    ) {}

    public function listAction(): ResponseInterface
    {
        // Check if user is logged in
        if (!$this->authenticationService->isUserLoggedIn($this->request)) {
            $this->addFlashMessage('Sie müssen angemeldet sein, um Ihre Bestellungen einzusehen.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $frontendUser = $this->authenticationService->getFrontendUser($this->request);
        if ($frontendUser === null) {
            return $this->htmlResponse();
        }

        $userId = (int)($frontendUser['uid'] ?? 0);
        $orders = $this->orderRepository->findByFrontendUserId($userId);

        $this->view->assignMultiple([
            'orders' => $orders,
        ]);

        return $this->htmlResponse();
    }

    public function detailAction(int $order = 0): ResponseInterface
    {
        // Check if user is logged in
        if (!$this->authenticationService->isUserLoggedIn($this->request)) {
            $this->addFlashMessage('Sie müssen angemeldet sein, um Ihre Bestellungen einzusehen.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Checkout');
        }

        $frontendUser = $this->authenticationService->getFrontendUser($this->request);
        if ($frontendUser === null) {
            return $this->htmlResponse();
        }

        $userId = (int)($frontendUser['uid'] ?? 0);
        
        if ($order === 0) {
            $this->addFlashMessage('Bestellung nicht gefunden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('list', 'Orders');
        }

        $orderObject = $this->orderRepository->findByUid($order);
        
        if ($orderObject === null) {
            $this->addFlashMessage('Bestellung nicht gefunden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('list', 'Orders');
        }

        // Verify that the order belongs to the logged-in user
        if ((int)($orderObject->getFrontendUserId() ?? 0) !== $userId) {
            $this->addFlashMessage('Sie haben keinen Zugriff auf diese Bestellung.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('list', 'Orders');
        }

        $this->view->assignMultiple([
            'order' => $orderObject,
        ]);

        return $this->htmlResponse();
    }
}
