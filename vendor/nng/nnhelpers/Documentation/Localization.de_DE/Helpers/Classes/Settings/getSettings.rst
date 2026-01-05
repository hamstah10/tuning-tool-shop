
.. include:: ../../../../Includes.txt

.. _Settings-getSettings:

==============================================
Settings::getSettings()
==============================================

\\nn\\t3::Settings()->getSettings(``$extensionName = '', $path = ''``);
----------------------------------------------

Holt das TypoScript-Setup und dort den Abschnitt "settings".
Werte aus dem FlexForm werden dabei nicht gemerged.

.. code-block:: php

	\nn\t3::Settings()->getSettings( 'nnsite' );
	\nn\t3::Settings()->getSettings( 'nnsite', 'example.path' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSettings( $extensionName = '', $path = '' )
   {
   	$pluginSettings = $this->getPlugin( $extensionName );
   	if (!$pluginSettings) return [];
   	if (!$path) return $pluginSettings['settings'] ?? [];
   	return $this->getFromPath( 'settings.'.$path, $pluginSettings ?? [] );
   }
   

