<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class CartCountViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;
    private const CART_SESSION_KEY = 'tuning_tool_shop_cart';

    public function render(): string
    {
        try {
            // Get current frontend user session
            $request = $this->renderingContext->getRequest();
            $frontendUser = $request?->getAttribute('frontend.user');
            
            error_log('[CartCountViewHelper] Frontend user: ' . ($frontendUser ? 'yes' : 'no'));
            
            if ($frontendUser === null) {
                return '0';
            }

            error_log('[CartCountViewHelper] Session key: ' . self::CART_SESSION_KEY);
            
            // Debug: dump all session keys
            error_log('[CartCountViewHelper] All session keys: ' . json_encode(array_keys($frontendUser->getSessionData()['ses'] ?? [])));
            
            // Get cart data directly from session
            $data = $frontendUser->getKey('ses', self::CART_SESSION_KEY);
            error_log('[CartCountViewHelper] Session data: ' . json_encode($data));
            
            if (!is_array($data) || !isset($data['items'])) {
                error_log('[CartCountViewHelper] No items in session');
                return '0';
            }

            // Calculate total quantity
            $itemCount = 0;
            foreach ($data['items'] as $item) {
                if (is_array($item) && isset($item['quantity'])) {
                    $itemCount += (int)$item['quantity'];
                }
            }
            
            error_log('[CartCountViewHelper] Final count: ' . $itemCount);
            return (string)$itemCount;
        } catch (\Throwable $e) {
            error_log('[CartCountViewHelper] Exception: ' . $e->getMessage());
            return '0';
        }
    }
}
