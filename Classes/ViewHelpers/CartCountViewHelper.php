<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CartCountViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    private ?CartItemRepository $cartItemRepository = null;

    public function __construct()
    {
    }

    public function render(): int
    {
        $sessionId = $this->getSessionId();
        $cartItems = $this->getCartItemRepository()->findBySessionId($sessionId);
        return count($cartItems);
    }

    private function getCartItemRepository(): CartItemRepository
    {
        if ($this->cartItemRepository === null) {
            $this->cartItemRepository = GeneralUtility::makeInstance(CartItemRepository::class);
        }
        return $this->cartItemRepository;
    }

    private function getSessionId(): string
    {
        // Check if frontend user is logged in
        $frontendUser = $GLOBALS['TSFE']->fe_user ?? null;

        if ($frontendUser !== null && isset($frontendUser->user['uid'])) {
            return 'user_' . $frontendUser->user['uid'];
        }

        // Fall back to cookie-based session
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
}
