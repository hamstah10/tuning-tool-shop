
.. include:: ../../../../Includes.txt

.. _Environment-getSyntheticFrontendRequest:

==============================================
Environment::getSyntheticFrontendRequest()
==============================================

\\nn\\t3::Environment()->getSyntheticFrontendRequest(``$pageUid = NULL``);
----------------------------------------------

Generiert einen virtuellen Frontend Request, der in jedem Context verwendet werden kann.
Initialisiert auch das Frontend TypoScript-Object und alle relevanten Objekte.

.. code-block:: php

	$request = \nn\t3::Environment()->getSyntheticFrontendRequest();

| ``@param int $pageUid``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSyntheticFrontendRequest( $pageUid = null )
   {
   	if (isset($this->SYNTHETIC_FE_REQUEST)) {
   		return $this->SYNTHETIC_FE_REQUEST;
   	}
   	// Resolve site + language + a page id (use site root as default)
   	$pageUid  = $pageUid ?: (int) (\nn\t3::Page()->getSiteRoot()['uid'] ?? 0);
   	$site	 = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
   	$langId   = $this->getLanguage();
   	$language = $site->getLanguageById($langId);
   	// Build base URI (fallback if site base is empty)
   	$base = (string)$site->getBase();
   	if ($base === '' || $base === '/') {
   		$base = $this->getBaseURL();
   	}
   	$uri = new Uri($base);
   	// Start request (URI first, then method in v13)
   	$queryParams = ['id' => $pageUid]; // make routing happy
   	$request = (new ServerRequest($uri, 'GET'))
   		->withAttribute('site', $site)
   		->withAttribute('language', $language)
   		->withQueryParams($queryParams);
   	// normalizedParams (what older code used to get from getIndpEnv)
   	$serverParams = [
   		'HTTP_HOST'	  => $uri->getHost() . ($uri->getPort() ? ':' . $uri->getPort() : ''),
   		'REQUEST_METHOD' => 'GET',
   		'REQUEST_URI'	=> $uri->getPath() === '' ? '/' : $uri->getPath(),
   		'QUERY_STRING'   => http_build_query($queryParams),
   		'HTTPS'		  => $uri->getScheme() === 'https' ? 'on' : 'off',
   		'SERVER_PORT'	=> $uri->getPort() ?: ($uri->getScheme() === 'https' ? 443 : 80),
   	];
   	$normalized = NormalizedParams::createFromServerParams($serverParams);
   	$request = $request->withAttribute('normalizedParams', $normalized);
   	// routing (PageArguments) — minimal but sufficient
   	$pageType = 0;
   	$routing  = new PageArguments($pageUid, $pageType, $queryParams);
   	$request  = $request->withAttribute('routing', $routing);
   	$request = $request->withAttribute(
   		'applicationType',
   		SystemEnvironmentBuilder::REQUESTTYPE_FE
   	);
   	// ensure full TypoScript even in "cached" context
   	$request = \nn\t3::Tsfe()->softDisableCache($request);
   	// Tiny handler to capture the mutated request
   	$captured = null;
   	$handler = new class($captured) implements RequestHandlerInterface {
   		public ?\Psr\Http\Message\ServerRequestInterface $captured;
   		public function __construct(&$_c) { $this->captured = &$_c; }
   		public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface {
   			$this->captured = $request;
   			return new HtmlResponse('');
   		}
   	};
   	// needed to prevent cross-contamination when in backend-context
   	$oldRequest = $GLOBALS['TYPO3_REQUEST'] ?? null;
   	// initialize FE controller (sets frontend.controller / $GLOBALS['TSFE'])
   	GeneralUtility::makeInstance(TypoScriptFrontendInitialization::class)->process($request, $handler);
   	$request = $handler->captured ?? $request;
   	// prepare TypoScript (attaches frontend.typoscript with FULL setup now)
   	GeneralUtility::makeInstance(PrepareTypoScriptFrontendRendering::class)->process($request, $handler);
   	$request = $handler->captured ?? $request;
   	$this->SYNTHETIC_FE_REQUEST = $request;
   	// reset to global request before capturing
   	$GLOBALS['TYPO3_REQUEST'] = $oldRequest;
   	return $request;
   }
   

