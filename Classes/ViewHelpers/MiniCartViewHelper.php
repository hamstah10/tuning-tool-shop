<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Service\SessionService;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MiniCartViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    private CartItemRepository $cartItemRepository;
    private SessionService $sessionService;

    public function __construct(
        CartItemRepository $cartItemRepository,
        SessionService $sessionService
    ) {
        $this->cartItemRepository = $cartItemRepository;
        $this->sessionService = $sessionService;
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
        try {
            $cartPageUid = $this->arguments['cartPageUid'] ?? 0;
            $itemsOnly = $this->arguments['itemsOnly'] ?? false;
            $listOnly = $this->arguments['listOnly'] ?? false;
            
            $sessionId = $this->getSessionId();
            $cartItems = $this->getCartItemRepository()->findBySessionId($sessionId);
            $itemCount = 0;

            foreach ($cartItems as $item) {
                if ($item->getProduct() !== null) {
                    $itemCount += $item->getQuantity();
                }
            }

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
        } catch (\Throwable $e) {
            // Log error and return empty string
            return '';
        }
    }

    private function renderItemsList($cartItems): string
    {
        if (count($cartItems) === 0) {
            return '<div class="mini-cart-empty">Warenkorb leer</div>';
        }

        $html = '<ul class="mini-cart-items">';
        foreach ($cartItems as $item) {
            $product = $item->getProduct();
            if ($product !== null) {
                $html .= sprintf(
                    '<li class="mini-cart-item"><span class="item-name">%s</span> <span class="item-qty">x%d</span></li>',
                    htmlspecialchars($product->getTitle()),
                    $item->getQuantity()
                );
            }
        }
        $html .= '</ul>';
        return $html;
    }

    private function getCartItemRepository(): CartItemRepository
    {
        return $this->cartItemRepository;
    }

    private function getSessionService(): SessionService
    {
        return $this->sessionService;
    }

    private function getSessionId(): string
    {
        // Try to get request from globals (most reliable)
        if (isset($GLOBALS['TYPO3_REQUEST']) && $GLOBALS['TYPO3_REQUEST'] instanceof ServerRequestInterface) {
            try {
                return $this->getSessionService()->getSessionIdFromRequest($GLOBALS['TYPO3_REQUEST']);
            } catch (\Throwable $e) {
                // Continue with fallback
            }
        }

        // Fallback: use SessionService for globals
        try {
            return $this->getSessionService()->getSessionIdFromGlobals();
        } catch (\Throwable $e) {
            // Final fallback: use random ID
            return 'fallback_' . md5(session_id() ?: uniqid('', true));
        }
    }

    private function generateCartLink(int $pageUid): string
    {
        return sprintf(
            'index.php?id=%d',
            $pageUid
        );
    }
}
