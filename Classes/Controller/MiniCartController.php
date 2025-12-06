<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class MiniCartController extends ActionController
{
    public function __construct(
        protected readonly CartItemRepository $cartItemRepository,
    ) {}

    public function indexAction(): ResponseInterface
    {
        try {
            $sessionId = $this->getSessionId();
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

    private function getSessionId(): string
    {
        $frontendUser = $this->request->getAttribute('frontend.user');

        if ($frontendUser !== null && $frontendUser->user !== null) {
            return 'user_' . $frontendUser->user['uid'];
        }

        if (!isset($_COOKIE['tx_tuning_tool_shop_session'])) {
            $sessionId = bin2hex(random_bytes(32));
            setcookie('tx_tuning_tool_shop_session', $sessionId, [
                'expires' => time() + 86400 * 30,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        } else {
            $sessionId = $_COOKIE['tx_tuning_tool_shop_session'];
        }

        return $sessionId;
    }

    private function getCartItems(): array
    {
        $sessionId = $this->getSessionId();

        return $this->cartItemRepository->findBySessionId($sessionId)->toArray();
    }
}
