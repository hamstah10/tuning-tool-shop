
.. include:: ../../../../Includes.txt

.. _Tsfe-injectTypoScript:

==============================================
Tsfe::injectTypoScript()
==============================================

\\nn\\t3::Tsfe()->injectTypoScript(``$request = NULL``);
----------------------------------------------

Vollständig initialisiertes TypoScript in den Request einschleusen.

Dies ist erforderlich, wenn in einem gecachten Frontend-Kontext ausgeführt wird,
in dem das TypoScript-Setup-Array nicht initialisiert ist. Es verwendet den
TypoScriptHelper, um ein vollständiges TypoScript-Objekt zu erstellen und es
in das ``frontend.typoscript``-Attribut des Requests einzuschleusen.

.. code-block:: php

	// In der Middleware:
	$request = \nn\t3::Tsfe()->injectTypoScript( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest $request``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function injectTypoScript( $request = null ): \TYPO3\CMS\Core\Http\ServerRequest
   {
   	$request = $request ?: \nn\t3::Environment()->getRequest();
   	// Check if TypoScript is already fully initialized
   	$existingTs = $request->getAttribute('frontend.typoscript');
   	if ($existingTs && $existingTs->hasSetup()) {
   		try {
   			$existingTs->getSetupArray();
   			// If no exception, TypoScript is already available
   			return $request;
   		} catch (\RuntimeException $e) {
   			// TypoScript not initialized, continue to inject
   		}
   	}
   	// Create full TypoScript using the helper
   	$pageUid = \nn\t3::Page()->getPid() ?: 1;
   	$helper = \nn\t3::injectClass( TypoScriptHelper::class );
   	$frontendTypoScript = $helper->getTypoScriptObject( $pageUid );
   	// Inject the TypoScript into the request
   	$request = $request->withAttribute('frontend.typoscript', $frontendTypoScript);
   	// Update both the Environment singleton and the TYPO3 global request
   	\nn\t3::Environment()->setRequest($request);
   	$GLOBALS['TYPO3_REQUEST'] = $request;
   	return $request;
   }
   

