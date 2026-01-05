<?php
namespace Nng\Nnrestapi\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * This Middleware is called BEFORE ALL other Middlewares.
 * (before `typo3/cms-frontend/timetracker`).
 * 
 * It checks, if the Frontend sent a preflight request (OPTIONS) and
 * sends back the headers indicating which request-types are allowed
 * and from which `Access-Control-Allow-Origin` (Domain).
 * 
 */
class CorsPreflightHeader implements MiddlewareInterface {

	public function process(
		ServerRequestInterface $request,
		RequestHandlerInterface $handler
	): ResponseInterface {

		$response = $handler->handle($request);		
		$method = strtolower($request->getMethod());

		if ($method != 'options') {
			return $response;
		}

		$response = \nn\t3::injectClass( \TYPO3\CMS\Core\Http\Response::class );
		\nn\rest::Header()->addControls( $response );

		// allow caching of preflight for future OPTIONS requests
		\nn\rest::Header()->add( $response, 'Access-Control-Max-Age', '86400' );
		\nn\rest::Header()->add( $response, 'Cache-Control', 'public, max-age=86400' );
		\nn\rest::Header()->add( $response, 'Vary', 'origin' );
		
		$response = $response->withStatus( 204, 'No Content' );

		return $response;

	}
}
