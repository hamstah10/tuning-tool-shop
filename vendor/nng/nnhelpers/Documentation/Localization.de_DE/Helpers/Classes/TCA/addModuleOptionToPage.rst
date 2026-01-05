
.. include:: ../../../../Includes.txt

.. _TCA-addModuleOptionToPage:

==============================================
TCA::addModuleOptionToPage()
==============================================

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
----------------------------------------------

In den Seiteneigenschaften unter "Verhalten -> Enthält Erweiterung" eine Auswahl-Option hinzufügen.
Klassischerweise in ``Configuration/TCA/Overrides/pages.php`` genutzt, früher in ``ext_tables.php``

.. code-block:: php

	// In ext_localconf.php das Icon registrieren (16 x 16 px SVG)
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('Beschreibung', 'identifier', 'icon-identifier');

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
   

