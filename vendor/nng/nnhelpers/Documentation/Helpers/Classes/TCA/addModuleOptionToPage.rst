
.. include:: ../../../../Includes.txt

.. _TCA-addModuleOptionToPage:

==============================================
TCA::addModuleOptionToPage()
==============================================

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
----------------------------------------------

Add a selection option in the page properties under "Behavior -> Contains extension".
Traditionally used in ``Configuration/TCA/Overrides/pages.php``, previously in ``ext_tables.php``

.. code-block:: php

	// Register the icon in ext_localconf.php (16 x 16 px SVG)
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('description', 'identifier', 'icon-identifier');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addModuleOptionToPage( $label, $identifier, $iconIdentifier = '')
   {
   	// Auswahl-Option hinzufügen
   	$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
   		0 => $label,
   		1 => $identifier,
   		2 => $iconIdentifier
   	];
   	// Icon im Seitenbaum verwenden
   	if ($iconIdentifier) {
   		$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-'.$identifier] = $iconIdentifier;
   	}
   }
   

