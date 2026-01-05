<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MiniCartViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;
    private const CART_SESSION_KEY = 'tuning_tool_shop_cart';

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

    public function render(): string
    {
        try {
            $cartPageUid = $this->arguments['cartPageUid'] ?? 0;
            $itemsOnly = $this->arguments['itemsOnly'] ?? false;
            $listOnly = $this->arguments['listOnly'] ?? false;
            
            error_log('[MiniCartViewHelper] render() called with cartPageUid=' . $cartPageUid . ', itemsOnly=' . ($itemsOnly ? 'true' : 'false') . ', listOnly=' . ($listOnly ? 'true' : 'false'));
            
            $request = $this->renderingContext->getRequest();
            $frontendUser = $request?->getAttribute('frontend.user');
            if ($frontendUser === null) {
                error_log('[MiniCartViewHelper] No frontend user');
                return '';
            }
            
            // Get cart data directly from session
            $data = $frontendUser->getKey('ses', self::CART_SESSION_KEY);
            error_log('[MiniCartViewHelper] Session data: ' . json_encode($data));
            
            if (!is_array($data) || !isset($data['items'])) {
                $itemCount = 0;
                $cartItems = [];
                error_log('[MiniCartViewHelper] No items in cart');
            } else {
                // Reconstruct items with product data
                $cartItems = [];
                $productRepository = GeneralUtility::makeInstance(ProductRepository::class);
                $itemCount = 0;
                
                foreach ($data['items'] as $itemData) {
                    if (!is_array($itemData) || !isset($itemData['product_uid'])) {
                        continue;
                    }
                    
                    $product = $productRepository->findByUidIgnoreStorage((int)$itemData['product_uid']);
                    if ($product !== null) {
                        $itemCount += (int)($itemData['quantity'] ?? 1);
                        $cartItems[] = [
                            'product' => $product,
                            'quantity' => (int)($itemData['quantity'] ?? 1),
                        ];
                    }
                }
                error_log('[MiniCartViewHelper] Items count: ' . $itemCount . ', cart items: ' . count($cartItems));
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

            $result = sprintf(
                '<a href="%s" class="mini-cart-link"><span class="mini-cart-count">%d</span> %s</a>',
                htmlspecialchars($cartLink),
                $itemCount,
                $itemCount === 1 ? 'Artikel' : 'Artikel'
            );
            error_log('[MiniCartViewHelper] Returning: ' . $result);
            return $result;
        } catch (\Throwable $e) {
            error_log('[MiniCartViewHelper] Exception: ' . $e->getMessage() . ' ' . $e->getTraceAsString());
            return '';
        }
    }

    private function renderItemsList(array $cartItems): string
    {
        if (count($cartItems) === 0) {
            return '<div class="mini-cart-empty">Warenkorb leer</div>';
        }

        $html = '<ul class="mini-cart-items">';
        foreach ($cartItems as $item) {
            $product = $item['product'] ?? null;
            if ($product !== null) {
                $html .= sprintf(
                    '<li class="mini-cart-item"><span class="item-name">%s</span> <span class="item-qty">x%d</span></li>',
                    htmlspecialchars($product->getTitle()),
                    $item['quantity'] ?? 1
                );
            }
        }
        $html .= '</ul>';
        return $html;
    }



    private function generateCartLink(int $pageUid): string
    {
        return sprintf(
            'index.php?id=%d',
            $pageUid
        );
    }
}
