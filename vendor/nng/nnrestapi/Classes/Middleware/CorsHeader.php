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
 * This Middleware is called on EVERY request - except preflight
 * requests (OPTIONS) which are handled by the `CorsPreflightHeader`
 * Middleware.
 * 
 * It adds the headers required for accessing the api-endpoints and
 * also eID requests. The most important header added is the 
 * `Access-Control-Allow-Origin`.
 * 
 */
class CorsHeader implements MiddlewareInterface {

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        // call all Middlewares and the ApiController
        $response = $handler->handle($request);

        // at this point all Middlewares have been processed, including PageResolver
        \nn\rest::Header()->addControls( $response );

        return $response;
    }
}
