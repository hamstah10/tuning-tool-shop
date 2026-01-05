
.. include:: ../../../../Includes.txt

.. _Http-buildUri:

==============================================
Http::buildUri()
==============================================

\\nn\\t3::Http()->buildUri(``$pageUid, $vars = [], $absolute = false``);
----------------------------------------------

Build URI, works in frontend and backend context.
Takes realURL into account

.. code-block:: php

	\nn\t3::Http()->buildUri( 123 );
	\nn\t3::Http()->buildUri( 123, ['test'=>1], true );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function buildUri ( $pageUid, $vars = [], $absolute = false )
   {
   	// Keine pid übergeben? Dann selbst ermitteln zu aktueller Seite
   	if (!$pageUid) $pageUid = \nn\t3::Page()->getPid();
   	// String statt pid übergeben? Dann Request per PHP bauen
   	if (!is_numeric($pageUid)) {
   		// relativer Pfad übergeben z.B. `/link/zu/seite`
   		if (strpos($pageUid, 'http') === false) {
   			$pageUid = \nn\t3::Environment()->getBaseURL() . ltrim( $pageUid, '/' );
   		}
   		$parsedUrl = parse_url($pageUid);
   		parse_str($parsedUrl['query'] ?? '', $parsedParams);
   		if (!$parsedParams) $parsedParams = [];
   		ArrayUtility::mergeRecursiveWithOverrule( $parsedParams, $vars );
   		$reqStr = $parsedParams ? http_build_query( $parsedParams ) : false;
   		$path = $parsedUrl['path'] ?: '/';
   		$port = $parsedUrl['port'] ?? false;
   		if ($port) $port = ":{$port}";
   		return "{$parsedUrl['scheme']}://{$parsedUrl['host']}{$port}{$path}" . ($reqStr ? '?'.$reqStr : '');
   	}
   	// Frontend initialisieren, falls nicht vorhanden
   	if (!\nn\t3::Environment()->isFrontend()) {
   		\nn\t3::Tsfe()->get();
   	}
   	$request = $GLOBALS['TYPO3_REQUEST'] ?? new \TYPO3\CMS\Core\Http\ServerRequest();
   	$cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
   	$cObj->setRequest( $request );
   	$uri = $cObj->typolink_URL([
   		'parameter' => $pageUid,
   		'linkAccessRestrictedPages' => 1,
   		'additionalParams' => GeneralUtility::implodeArrayForUrl('', $vars),
   	]);
   	// setAbsoluteUri( TRUE ) geht nicht immer...
   	if ($absolute) {
   		$uri = GeneralUtility::locationHeaderUrl($uri);
   	}
   	return $uri;
   }
   

