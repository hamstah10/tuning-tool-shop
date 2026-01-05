<?php
declare(strict_types = 1);

namespace Nng\Nnhelpers\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * ## RequestParser
 *
 * In `ext_localconf.php` und `Configuration/Middlewares.php` registrierter
 * Handler für HTTP-Request. Wir im Boot-Prozess vor allen anderen Middlewares aufgerufen.
 *
 */
class RequestParser implements MiddlewareInterface
{
	/**
	 * ## Handler aus `Configuration/Middlewares.php`
	 *
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface

	{
		\nn\t3::Environment()->setRequest($request);
		return $handler->handle($request);
	}
}
