<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class AuthenticationService
{
    /**
     * Check if a frontend user is logged in
     */
    public function isUserLoggedIn(ServerRequestInterface $request): bool
    {
        $frontendUser = $request->getAttribute('frontend.user');
        
        return $frontendUser instanceof FrontendUserAuthentication 
            && isset($frontendUser->user) 
            && is_array($frontendUser->user) 
            && !empty($frontendUser->user);
    }

    /**
     * Get the logged-in frontend user
     */
    public function getFrontendUser(ServerRequestInterface $request): ?array
    {
        $frontendUser = $request->getAttribute('frontend.user');
        
        if ($frontendUser instanceof FrontendUserAuthentication && isset($frontendUser->user)) {
            return $frontendUser->user;
        }
        
        return null;
    }

    /**
     * Get the femanager login page URL from settings
     */
    public function getLoginPageUrl(array $settings, ?string $returnUrl = null): string
    {
        $loginPid = (int)($settings['femanagerLoginPid'] ?? 0);
        $url = $loginPid > 0 ? '/index.php?id=' . $loginPid : '/';
        
        if ($returnUrl) {
            $url .= (strpos($url, '?') !== false ? '&' : '?') . 'redirect_url=' . urlencode($returnUrl);
        }
        
        return $url;
    }

    /**
     * Get the femanager registration page URL from settings
     */
    public function getRegistrationPageUrl(array $settings): string
    {
        $registrationPid = (int)($settings['femanagerRegistrationPid'] ?? 0);
        return $registrationPid > 0 ? '/index.php?id=' . $registrationPid : '/';
    }
}
