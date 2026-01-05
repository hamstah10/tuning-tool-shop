
.. include:: ../../../../Includes.txt

.. _Tsfe-cObj:

==============================================
Tsfe::cObj()
==============================================

\\nn\\t3::Tsfe()->cObj(``$request = NULL``);
----------------------------------------------

$GLOBALS['TSFE']->cObj holen.

.. code-block:: php

	// seit TYPO3 12.4 innerhalb eines Controllers:
	\nn\t3::Tsfe()->cObj( $this->request  )

| ``@return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function cObj( $request = null )
   {
   	$request = $request ?: \nn\t3::Environment()->getSyntheticFrontendRequest();
   	if ($request) {
   		if ($cObj = $request->getAttribute('currentContentObject')) {
   			return $cObj;
   		}
   	}
   	$cObjRenderer = \nn\t3::injectClass(ContentObjectRenderer::class);
   	$cObjRenderer->setRequest( $request );
   	return $cObjRenderer;
   }
   

