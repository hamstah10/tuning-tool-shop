<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Session\UserSessionManager;

class SessionService
{
    private const COOKIE_NAME = 'tx_tuning_tool_shop_session';

    /**
     * Get session ID from request
     */
    public function getSessionIdFromRequest(ServerRequestInterface $request): string
    {
        // 1. First priority: Middleware set the session ID
        $sessionId = $request->getAttribute('tx_tuning_tool_shop_session_id');
        if (!empty($sessionId)) {
            return $sessionId;
        }

        // 2. Check if frontend user is logged in
        $frontendUser = $request->getAttribute('frontend.user');
        if ($frontendUser !== null && $frontendUser->user !== null && isset($frontendUser->user['uid'])) {
            return 'user_' . $frontendUser->user['uid'];
        }

        // 3. Check for anonymous cart cookie in REQUEST
        $cookies = $request->getCookieParams();
        if (isset($cookies[self::COOKIE_NAME]) && !empty($cookies[self::COOKIE_NAME])) {
            return $cookies[self::COOKIE_NAME];
        }

        // 4. Check for anonymous cart cookie in $_COOKIE (fallback)
        if (isset($_COOKIE[self::COOKIE_NAME]) && !empty($_COOKIE[self::COOKIE_NAME])) {
            return $_COOKIE[self::COOKIE_NAME];
        }

        // 5. Try to use TYPO3 Frontend Session
        try {
            if (isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->fe_user) {
                $sessionData = $GLOBALS['TSFE']->fe_user->getSessionData('tx_tuning_tool_shop');
                if (isset($sessionData['sessionId']) && !empty($sessionData['sessionId'])) {
                    return $sessionData['sessionId'];
                }
            }
        } catch (\Throwable) {
            // Session access failed, continue
        }

        // 6. Generate a new session ID if nothing else worked
        $newSessionId = 'anon_' . bin2hex(random_bytes(16));
        
        // Try to store it in TYPO3 session for next request
        try {
            if (isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->fe_user) {
                $GLOBALS['TSFE']->fe_user->setAndSaveSessionData('tx_tuning_tool_shop', ['sessionId' => $newSessionId]);
            }
        } catch (\Throwable) {
            // Session storage failed, continue anyway
        }
        
        return $newSessionId;
    }

    /**
     * Get session ID from globals (for ViewHelpers, etc.)
     */
    public function getSessionIdFromGlobals(): string
    {
        // Check if frontend user is logged in
        $frontendUser = $GLOBALS['TSFE']->fe_user ?? null;
        if ($frontendUser !== null && isset($frontendUser->user['uid'])) {
            return 'user_' . $frontendUser->user['uid'];
        }

        // For anonymous users, use persistent cookie if available
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            return $_COOKIE[self::COOKIE_NAME];
        }

        // If no cookie, try PHP session
        if (session_id()) {
            return 'session_' . session_id();
        }

        // Fallback: use a unique identifier
        return 'anon_' . md5(php_uname() . time() . mt_rand());
    }
}
