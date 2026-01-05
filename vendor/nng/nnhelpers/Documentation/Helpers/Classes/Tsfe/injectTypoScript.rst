
.. include:: ../../../../Includes.txt

.. _Tsfe-injectTypoScript:

==============================================
Tsfe::injectTypoScript()
==============================================

\\nn\\t3::Tsfe()->injectTypoScript(``$request = NULL``);
----------------------------------------------

Inject fully initialized TypoScript into the request.

This is necessary when executing in a cached frontend context
in which the TypoScript setup array is not initialized. It uses the
TypoScriptHelper to create a complete TypoScript object and place it
into the ``frontend.typoscript attribute`` of the request.

.. code-block:: php

	// In the middleware:
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
   

