
.. include:: ../../../../Includes.txt

.. _Registry-getVendorExtensionName:

==============================================
Registry::getVendorExtensionName()
==============================================

\\nn\\t3::Registry()->getVendorExtensionName(``$combinedVendorPluginName = ''``);
----------------------------------------------

Plugin-Name generieren.
Abhängig von Typo3-Version wird der Plugin-Name mit oder ohne Vendor zurückgegeben.

.. code-block:: php

	    \nn\t3::Registry()->getVendorExtensionName( 'nncalendar' );    // => Nng.Nncalendar
	    \nn\t3::Registry()->getVendorExtensionName( 'Nng\Nncalendar' );    // => Nng.Nncalendar

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getVendorExtensionName( $combinedVendorPluginName = '' )
   {
   	// Nng als Vendor-Name verwenden, falls nichts angegeben.
   	$combinedVendorPluginName = str_replace('\\', '.', $combinedVendorPluginName);
   	if (strpos($combinedVendorPluginName, '.') === false) {
   		$combinedVendorPluginName = 'Nng.'.$combinedVendorPluginName;
   	}
   	$parts = explode('.', $combinedVendorPluginName);
   	$vendorName = GeneralUtility::underscoredToUpperCamelCase( $parts[0] );
   	$pluginName = GeneralUtility::underscoredToUpperCamelCase( $parts[1] );
   	$registrationName = "{$pluginName}";
   	return $registrationName;
   }
   

