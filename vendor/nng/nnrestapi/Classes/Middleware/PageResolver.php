<?php

namespace Nng\Nnrestapi\Middleware;

use Nng\Nnrestapi\Mvc\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;

/**
 * PageResolver MiddleWare.
 * 
 * Takes care of analysing the request and checking, if an Endpoint was defined for the request.
 * Creates an Instance of the `ApiController` which will then handle the actual method call in
 * the Endpoint.
 * 
 * Request handling in MiddleWare / TYPO3 docs:
 * https://bit.ly/3GBcveH
 * 
 */
class PageResolver implements MiddlewareInterface {
		
	/** 
	 * @var \Nng\Nnrestapi\Mvc\Response
	 */
    private $response;

	/**
	 *	@param ServerRequestInterface $request
	 *	@param RequestHandlerInterface $handler
	 *	@return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface 
	{
		if (!\Nng\Nnrestapi\Mvc\Request::isApiRequest($request)) {
			return $handler->handle($request);
		}

		// Inject full TypoScript into request - needed when page is cached and TypoScript setup is not initialized
		$request = \nn\t3::Tsfe()->injectTypoScript($request);

		// Initialize the Settings singleton. Must be done after `typo3/cms-frontend/site` MiddleWare 
		// and before `\nn\rest::Settings()` is used anywhere
		\nn\rest::Settings()->setRequest( $request );

		$method = strtolower($request->getMethod());
		$endpoint = \nn\rest::Endpoint()->findForRequest( $request );

		// URL does not contain the base path to the api (e.g. `/api/...`)? Then abort.
		if ($endpoint === null) {
			return $handler->handle($request);
		}

		// Should go to API, but URL could be mapped to controller? Output 404
		if (!($endpoint['class'] ?? false)) {

			$args = $endpoint['args'];
			$endpointsForController = \nn\rest::Endpoint()->findEndpointsForController( $args['controller'] );

			$firstEndpoint = array_shift($endpointsForController);
			$className = $firstEndpoint['class'] ?? ucfirst($args['controller']);

			$className = \nn\rest::Endpoint()->kebabToCamelCase( $className );
			$action = \nn\rest::Endpoint()->kebabToCamelCase( $args['action'] );
	
			$classMethodInfo = ucfirst($className) . '::' . $method . ucfirst($action) . 'Action()';

			$response = \nn\t3::injectClass(\TYPO3\CMS\Core\Http\Response::class );
			\nn\rest::Header()->addControls( $response );
			$response = $response->withStatus( 404, 'Not found' );
			$response->getBody()->write(json_encode([
				'status'	=> 404, 
				'error'		=> 'RestApi-endpoint not found. Based on your request the endpoint would be `' . $classMethodInfo . '`',
				'code'		=> 404,
			]));
			return $response;
		}

		$settings = \nn\t3::Settings()->get('tx_nnrestapi');

		// Compensate problems with JS date-pickers
		if ($timeZone = $settings['timeZone'] ?? false) {
			date_default_timezone_set( $timeZone );
		}

		$this->response = \nn\t3::injectClass( Response::class );
		$this->response->setEndpoint( $endpoint );
		$this->response->setSettings( $settings );

		$apiRequest = new \Nng\Nnrestapi\Mvc\Request( $request );
		$apiRequest->setFeUser( \nn\t3::FrontendUser()->get() );
		$apiRequest->setEndpoint( $endpoint );
		$apiRequest->setArguments( $endpoint['route']['arguments'] ?? [] );
		$apiRequest->setSettings( $settings );

		$controller = \nn\t3::injectClass( $settings['apiController'] );
		$controller->setRequest( $apiRequest );
		$controller->setResponse( $this->response );
		$controller->setSettings( $settings );

		// init the logger
		$logger = \nn\rest::Log( $apiRequest )->setResponse( $this->response );

		try {
            $response = $controller->indexAction();
		} catch ( PropagateResponseException $e ) {
			// PropagateResponseException contains a response - extract and add CORS headers
			$response = $e->getResponse();
			\nn\rest::Header()->addControls( $response );
			$logger->error($e, $response);
			throw new PropagateResponseException($response, $e->getCode());
		} catch( \Exception $e ) {
			\nn\rest::Header()->exception( $e->getMessage(), 500 );
			$logger->error($e, $response);
			throw $e;
		} catch( \Error $e ) {
			\nn\rest::Header()->exception( $e->getMessage(), $e->getCode() );
			$logger->error($e);
			throw $e;
		}

		$logger->request();

		// Add CORS headers to response (if we have a response)
		if (isset($response) && $response instanceof ResponseInterface) {
			\nn\rest::Header()->addControls( $response );
			return $response;
		}

		// Fallback: create error response
		$response = \nn\t3::injectClass(\TYPO3\CMS\Core\Http\Response::class);
		\nn\rest::Header()->addControls( $response );
		return $response->withStatus(500);

	}

}