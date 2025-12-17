<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Service\SessionService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class MiniCartController extends ActionController
{
    public function __construct(
        protected readonly CartItemRepository $cartItemRepository,
        protected readonly SessionService $sessionService,
    ) {}

    public function indexAction(): ResponseInterface
    {
        try {
            $sessionId = $this->sessionService->getSessionIdFromRequest($this->request);
            $cartItems = $this->cartItemRepository->findBySessionId($sessionId)->toArray();
            $itemCount = 0;
            $totalGross = 0.0;

            foreach ($cartItems as $cartItem) {
                if ($cartItem->getProduct() !== null) {
                    $itemCount += $cartItem->getQuantity();
                    $totalGross += $cartItem->getSubtotal();
                }
            }

            $cartPid = (int)($this->settings['cartPid'] ?? 0);

            $this->view->assignMultiple([
                'cartItems' => $cartItems,
                'itemCount' => $itemCount,
                'total' => $totalGross,
                'cartPid' => $cartPid,
            ]);
        } catch (\Exception $e) {
            // Fallback wenn Error
            $this->view->assignMultiple([
                'cartItems' => [],
                'itemCount' => 0,
                'total' => 0.0,
                'cartPid' => 0,
            ]);
        }

        return $this->htmlResponse();
    }

}
