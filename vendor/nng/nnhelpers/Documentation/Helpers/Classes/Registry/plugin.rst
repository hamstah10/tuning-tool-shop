
.. include:: ../../../../Includes.txt

.. _Registry-plugin:

==============================================
Registry::plugin()
==============================================

\\nn\\t3::Registry()->plugin(``$vendorName = '', $pluginName = '', $title = '', $icon = '', $tcaGroup = NULL``);
----------------------------------------------

Register a plugin for selection via the dropdown ``CType`` in the backend.
Use in ``Configuration/TCA/Overrides/tt_content.php`` Ã¢ or ``ext_tables.php`` (deprecated).

.. code-block:: php

	\nn\t3::Registry()->plugin( 'nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );
	\nn\t3::Registry()->plugin( 'Nng\Nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function plugin ( $vendorName = '', $pluginName = '', $title = '', $icon = '', $tcaGroup = null )
   {
   	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin( $this->getVendorExtensionName($vendorName), $pluginName, $title, $icon, $tcaGroup );
   }
   

