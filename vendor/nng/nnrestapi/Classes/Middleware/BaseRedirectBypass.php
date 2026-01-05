<?php

namespace Nng\Nnrestapi\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Site\Entity\Site;

/**
 * BaseRedirectBypass MiddleWare.
 * 
 * Prevents TYPO3's `base-redirect-resolver` from redirecting API requests
 * to a language prefix (e.g. `/api/...` -> `/en/api/...`).
 * 
 * This middleware must run BEFORE `typo3/cms-frontend/base-redirect-resolver`
 * but AFTER `typo3/cms-frontend/site` to have access to the site configuration.
 * 
 * For multilingual sites where all languages have URL prefixes (e.g. `/en/`, `/de/`),
 * requests to `/api/...` would otherwise be redirected, causing 404 errors.
 * 
 * The solution: If the request path starts with the API basePath, we set the
 * default language on the request, which prevents the base-redirect-resolver
 * from issuing a redirect.
 */
class BaseRedirectBypass implements MiddlewareInterface 
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface 
    {
        $site = $request->getAttribute('site');
        
        if (!$site instanceof Site) {
            return $handler->handle($request);
        }

        // Check if this is an API request
        if (!\Nng\Nnrestapi\Mvc\Request::isApiRequest($request)) {
            return $handler->handle($request);
        }

        // This is an API request - check if we already have a language set
        $language = $request->getAttribute('language');
        
        if ($language !== null) {
            // Language already set (e.g. request was /en/api/...), continue normally
            return $handler->handle($request);
        }

        // No language set yet - this means base-redirect-resolver would redirect.
        // Set the default language on both 'language' attribute and 'routing' attribute
        // to prevent the redirect and ensure PageRouter can resolve the request.
        $defaultLanguage = $site->getDefaultLanguage();
        $request = $request->withAttribute('language', $defaultLanguage);

        // Update the routing attribute with the default language
        $previousRouting = $request->getAttribute('routing');
        if ($previousRouting instanceof SiteRouteResult) {
            $newRouting = new SiteRouteResult(
                $previousRouting->getUri(),
                $previousRouting->getSite(),
                $defaultLanguage,
                $previousRouting->getTail()
            );
            $request = $request->withAttribute('routing', $newRouting);
        }
        
        return $handler->handle($request);
    }
}
