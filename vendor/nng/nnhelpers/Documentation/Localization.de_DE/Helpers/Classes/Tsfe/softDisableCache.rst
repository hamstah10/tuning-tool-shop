
.. include:: ../../../../Includes.txt

.. _Tsfe-softDisableCache:

==============================================
Tsfe::softDisableCache()
==============================================

\\nn\\t3::Tsfe()->softDisableCache(``$request = NULL``);
----------------------------------------------

Cache für das Frontend deaktivieren.

"Softe" Variante: Nutzt ein fake USER_INT-Objekt, damit bereits gerenderte
Elemente nicht neu gerendert werden müssen. Workaround für TYPO3 v12+, da
TypoScript Setup & Constants nicht mehr initialisiert werden, wenn Seite
vollständig aus dem Cache geladen werden.

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
   

