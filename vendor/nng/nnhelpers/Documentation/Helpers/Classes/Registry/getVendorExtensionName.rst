
.. include:: ../../../../Includes.txt

.. _Registry-getVendorExtensionName:

==============================================
Registry::getVendorExtensionName()
==============================================

\\nn\\t3::Registry()->getVendorExtensionName(``$combinedVendorPluginName = ''``);
----------------------------------------------

Generate plugin name.
Depending on the Typo3 version, the plugin name is returned with or without the vendor.

.. code-block:: php

	    \nn\t3::Registry()->getVendorExtensionName( 'nncalendar' ); // => Nng.Nncalendar
	    \nn\t3::Registry()->getVendorExtensionName( 'Nng\Nncalendar' ); // => Nng.Nncalendar

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
   

