<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class MiniCartViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    private ?CartItemRepository $cartItemRepository = null;

    public function __construct()
    {
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'cartPageUid',
            'int',
            'UID der Warenkorbseite für den Link',
            false
        );
        $this->registerArgument(
            'itemsOnly',
            'bool',
            'Nur die Anzahl anzeigen, ohne Link',
            false,
            false
        );
        $this->registerArgument(
            'listOnly',
            'bool',
            'Nur die Artikelliste anzeigen, ohne Link zum Warenkorb',
            false,
            false
        );
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): mixed {
        // Dieser ViewHelper benötigt Instanzen, verwende render() stattdessen
        return '';
    }

    public function render(): string
    {
        $cartPageUid = $this->arguments['cartPageUid'];
        $itemsOnly = $this->arguments['itemsOnly'];
        $listOnly = $this->arguments['listOnly'];
        $sessionId = $this->getSessionId();
        $cartItems = $this->getCartItemRepository()->findBySessionId($sessionId);
        $itemCount = count($cartItems);

        // Return only item count if requested
        if ($itemsOnly) {
            return (string)$itemCount;
        }

        // Return only list if requested
        if ($listOnly) {
            return $this->renderItemsList($cartItems);
        }

        // Generate cart link
        $cartLink = $this->generateCartLink($cartPageUid);

        return sprintf(
            '<a href="%s" class="mini-cart-link"><span class="mini-cart-count">%d</span> %s</a>',
            htmlspecialchars($cartLink),
            $itemCount,
            $itemCount === 1 ? 'Artikel' : 'Artikel'
        );
    }

    private function renderItemsList($cartItems): string
    {
        if (count($cartItems) === 0) {
            return '<div class="mini-cart-empty">Warenkorb leer</div>';
        }

        $html = '<ul class="mini-cart-items">';
        foreach ($cartItems as $item) {
            $product = $item->getProduct();
            $html .= sprintf(
                '<li class="mini-cart-item"><span class="item-name">%s</span> <span class="item-qty">x%d</span></li>',
                htmlspecialchars($product->getTitle()),
                $item->getQuantity()
            );
        }
        $html .= '</ul>';
        return $html;
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

    private function generateCartLink(int $pageUid): string
    {
        return sprintf(
            'index.php?id=%d',
            $pageUid
        );
    }
}
