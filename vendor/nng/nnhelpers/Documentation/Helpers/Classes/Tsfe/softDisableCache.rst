
.. include:: ../../../../Includes.txt

.. _Tsfe-softDisableCache:

==============================================
Tsfe::softDisableCache()
==============================================

\\nn\\t3::Tsfe()->softDisableCache(``$request = NULL``);
----------------------------------------------

Deactivate cache for the frontend.

"Soft" variant: Uses a fake USER_INT object so that already rendered elements
elements do not have to be rendered again. Workaround for TYPO3 v12+, since
TypoScript Setup & Constants are no longer initialized when page is
completely loaded from the cache.

.. code-block:: php

	\nn\t3::Tsfe()->softDisableCache()

| ``@param \TYPO3\CMS\Core\Http\ServerRequest $request``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function softDisableCache( $request = null ): \TYPO3\CMS\Core\Http\ServerRequest
   {
   	$request = $request ?: \nn\t3::Environment()->getRequest();
   	$cacheInstruction = $request->getAttribute(
   		'frontend.cache.instruction',
   		new CacheInstruction()
   	);
   	$cacheInstruction->disableCache('App needs full TypoScript. Cache disabled by \nn\t3::Tsfe()->softDisableCache()');
   	$request = $request->withAttribute('frontend.cache.instruction', $cacheInstruction);
   	return $request;
   }
   

