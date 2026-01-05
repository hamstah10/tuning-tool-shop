
.. include:: ../../../../Includes.txt

.. _Registry-configurePlugin:

==============================================
Registry::configurePlugin()
==============================================

\\nn\\t3::Registry()->configurePlugin(``$vendorName = '', $pluginName = '', $cacheableActions = [], $uncacheableActions = []``);
----------------------------------------------

Ein Plugin konfigurieren.
In ``ext_localconf.php`` nutzen.

.. code-block:: php

	\nn\t3::Registry()->configurePlugin( 'Nng\Nncalendar', 'Nncalendar',
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	    [\Nng\ExtName\Controller\MainController::class => 'show']
	);

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function configurePlugin ( $vendorName = '', $pluginName = '', $cacheableActions = [], $uncacheableActions = [] )
   {
   	$registrationName = $this->getVendorExtensionName($vendorName);
   	$pluginName = GeneralUtility::underscoredToUpperCamelCase( $pluginName );
   	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
   		$registrationName, $pluginName,
   		$this->parseControllerActions($cacheableActions),
   		$this->parseControllerActions($uncacheableActions)
   	);
   }
   

