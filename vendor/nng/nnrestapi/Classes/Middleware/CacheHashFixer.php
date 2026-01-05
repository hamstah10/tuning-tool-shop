<?php

namespace Nng\Nnrestapi\Middleware;

use Nng\Nnrestapi\Mvc\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Site\Entity\NullSite;

/**
 * CacheHashFixer MiddleWare.
 * Disables the `&cHash` check for requests targeting the nnrestapi.
 * 
 * This can also be done in the `LocalConfiguration.php` / `settings.php`
 * but most of the time you want to keep it activated for all other requests.
 * 
 * Without this, TYPO3 will throw an ERROR 404
 * `Reason: Request parameters could not be validated (&cHash empty)`
 * 
 * Request handling in MiddleWare / TYPO3 docs:
 * https://bit.ly/3GBcveH
 * 
 */
class CacheHashFixer implements MiddlewareInterface 
{		
	/** 
	 * @var \Nng\Nnrestapi\Mvc\Response
	 */
    private $response;

	/**
	 * 
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface 
	{
		$site = $request->getAttribute('site');

		if ($site instanceof NullSite) {
			return $handler->handle($request);
		}

		// hacky, but how on earth else?
		if (\Nng\Nnrestapi\Mvc\Request::isApiRequest($request)) {
			$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false;
			$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['enforceValidation'] = false;
		}

		return $handler->handle($request);
	}

}