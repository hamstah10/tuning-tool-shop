<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Session\UserSessionManager;
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

        // Try to get session from TYPO3 frontend session
        try {
            $session = $GLOBALS['TSFE']->fe_user->getSession();
            if ($session !== null && $session->getIdentifier()) {
                return $session->getIdentifier();
            }
        } catch (\Exception) {
            // Fallback
        }

        // Fall back to reading the cookie directly
        return $_COOKIE['tx_tuning_tool_shop_session'] ?? '';
    }
}
