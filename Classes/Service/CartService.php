<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use Hamstahstudio\TuningToolShop\Domain\Model\CartItem;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class CartService
{
    private const CART_SESSION_KEY = 'tuning_tool_shop_cart';

    /**
     * Get cart items from TYPO3 frontend user session
     * This will create an anonymous frontend user if none is logged in
     * and will automatically migrate cart when a user logs in
     * 
     * @return CartItem[]
     */
    public function getCartItemsFromSession(FrontendUserAuthentication $frontendUser): array
    {
        $data = $frontendUser->getKey('ses', self::CART_SESSION_KEY);
        
        error_log('[CartService::getCartItemsFromSession] Raw session data: ' . json_encode($data));

        if (!is_array($data) || !isset($data['items'])) {
            error_log('[CartService::getCartItemsFromSession] No items in session');
            return [];
        }

        // Reconstruct CartItem objects from stored data
        $cartItems = [];
        $productRepository = GeneralUtility::makeInstance(ProductRepository::class);
        foreach ($data['items'] as $itemData) {
            if (!is_array($itemData) || !isset($itemData['product_uid'])) {
                continue;
            }

            $product = $productRepository->findByUidIgnoreStorage((int)$itemData['product_uid']);
            if ($product === null) {
                continue;
            }

            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity((int)($itemData['quantity'] ?? 1));
            $cartItems[] = $cartItem;
        }

        return $cartItems;
    }

    /**
     * Store cart items in TYPO3 frontend user session
     * Only stores product UIDs and quantities, not serialized objects
     * 
     * @param CartItem[] $cartItems
     */
    public function storeCartInSession(FrontendUserAuthentication $frontendUser, array $cartItems): void
    {
        // Convert CartItem objects to simple arrays (UIDs + quantities only)
        $itemsData = [];
        foreach ($cartItems as $item) {
            if ($item->getProduct() !== null) {
                $itemsData[] = [
                    'product_uid' => $item->getProduct()->getUid(),
                    'quantity' => $item->getQuantity(),
                ];
            }
        }

        $data = [
            'items' => $itemsData,
            'lastUpdated' => time(),
        ];
        
        error_log('[CartService::storeCartInSession] Key: ' . self::CART_SESSION_KEY . ', Data: ' . json_encode($data));
        error_log('[CartService::storeCartInSession] Frontend user ID: ' . ($frontendUser->user['uid'] ?? 'null'));
        
        $frontendUser->setKey('ses', self::CART_SESSION_KEY, $data);
        $result = $frontendUser->storeSessionData();
        
        error_log('[CartService::storeCartInSession] storeSessionData returned: ' . ($result ? 'true' : 'false'));
    }

    /**
     * Get total item count from cart (sum of all quantities)
     */
    public function getItemCount(FrontendUserAuthentication $frontendUser): int
    {
        $cartItems = $this->getCartItemsFromSession($frontendUser);
        $itemCount = 0;
        foreach ($cartItems as $item) {
            $itemCount += $item->getQuantity();
        }
        
        error_log('[CartService::getItemCount] Count: ' . $itemCount . ', Items: ' . count($cartItems));
        
        return $itemCount;
    }
}
