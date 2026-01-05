<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

/**
 * Service to manage cart data in TYPO3 frontend user sessions
 * This uses the native TYPO3 session API which automatically handles
 * migration from anonymous to logged-in users
 */
final class CartSessionService
{
    private const SESSION_KEY = 'tuning_tool_shop_cart';

    /**
     * Get cart item IDs from the frontend user session
     */
    public function getCartItemIdsFromRequest(ServerRequestInterface $request): array
    {
        $frontendUser = $request->getAttribute('frontend.user');
        if (!$frontendUser instanceof FrontendUserAuthentication) {
            return [];
        }

        $data = $frontendUser->getKey('ses', self::SESSION_KEY);
        if (is_array($data) && isset($data['itemIds'])) {
            return $data['itemIds'];
        }

        return [];
    }

    /**
     * Get cart item IDs from globals (for ViewHelpers)
     */
    public function getCartItemIds(): array
    {
        $frontendUser = $GLOBALS['TSFE']?->fe_user;
        if ($frontendUser === null) {
            return [];
        }

        $data = $frontendUser->getKey('ses', self::SESSION_KEY);
        if (is_array($data) && isset($data['itemIds'])) {
            return $data['itemIds'];
        }

        return [];
    }

    /**
     * Add a cart item ID to the session
     */
    public function addItemToSession(ServerRequestInterface $request, int $itemUid): void
    {
        $frontendUser = $request->getAttribute('frontend.user');
        if (!$frontendUser instanceof FrontendUserAuthentication) {
            return;
        }

        $data = $frontendUser->getKey('ses', self::SESSION_KEY) ?? [];
        if (!is_array($data)) {
            $data = [];
        }

        if (!isset($data['itemIds'])) {
            $data['itemIds'] = [];
        }

        if (!in_array($itemUid, $data['itemIds'], true)) {
            $data['itemIds'][] = $itemUid;
        }

        $frontendUser->setKey('ses', self::SESSION_KEY, $data);
        $frontendUser->storeSessionData();
    }

    /**
     * Remove a cart item ID from the session
     */
    public function removeItemFromSession(ServerRequestInterface $request, int $itemUid): void
    {
        $frontendUser = $request->getAttribute('frontend.user');
        if (!$frontendUser instanceof FrontendUserAuthentication) {
            return;
        }

        $data = $frontendUser->getKey('ses', self::SESSION_KEY) ?? [];
        if (!is_array($data)) {
            $data = [];
        }

        if (!isset($data['itemIds'])) {
            $data['itemIds'] = [];
        }

        $data['itemIds'] = array_values(array_diff($data['itemIds'], [$itemUid]));

        $frontendUser->setKey('ses', self::SESSION_KEY, $data);
        $frontendUser->storeSessionData();
    }

    /**
     * Clear all items from the session
     */
    public function clearSession(ServerRequestInterface $request): void
    {
        $frontendUser = $request->getAttribute('frontend.user');
        if (!$frontendUser instanceof FrontendUserAuthentication) {
            return;
        }

        $frontendUser->setKey('ses', self::SESSION_KEY, null);
        $frontendUser->storeSessionData();
    }
}
