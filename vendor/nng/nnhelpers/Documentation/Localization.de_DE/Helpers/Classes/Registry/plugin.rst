
.. include:: ../../../../Includes.txt

.. _Registry-plugin:

==============================================
Registry::plugin()
==============================================

\\nn\\t3::Registry()->plugin(``$vendorName = '', $pluginName = '', $title = '', $icon = '', $tcaGroup = NULL``);
----------------------------------------------

Ein Plugin registrieren zur Auswahl über das Dropdown ``CType`` im Backend.
In ``Configuration/TCA/Overrides/tt_content.php`` nutzen – oder ``ext_tables.php`` (veraltet).

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
   

