
.. include:: ../../../../Includes.txt

.. _Tsfe-forceAbsoluteUrls:

==============================================
Tsfe::forceAbsoluteUrls()
==============================================

\\nn\\t3::Tsfe()->forceAbsoluteUrls(``$enable = true``);
----------------------------------------------

Setzt ``config.absRefPrefix`` auf die aktuelle URL.

Damit werden beim Rendern der Links von Content-Elementen
absolute URLs verwendet. Funktioniert zur Zeit (noch) nicht für Bilder.

.. code-block:: php

	\nn\t3::Environment()->forceAbsoluteUrls();
	$html = \nn\t3::Content()->render(123);

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function forceAbsoluteUrls( $enable = true )
   {
   	$request = \nn\t3::Environment()->getRequest();
   	$fts = $request->getAttribute('frontend.typoscript');
   	if (!$fts) return $request;
   	$base = rtrim((string)$request->getAttribute('site')->getBase(), '/') . '/';
   	$config = $fts->getConfigArray() ?? [];
   	$config['absRefPrefix'] = $base;
   	$config['forceAbsoluteUrls'] = $enable;
   	if (method_exists($fts, 'setConfigArray')) {
   		$fts->setConfigArray($config);
   		$request = $request->withAttribute('frontend.typoscript', $fts);
   	}
   	\nn\t3::Environment()->setRequest($request);
   	return $request;
   }
   

