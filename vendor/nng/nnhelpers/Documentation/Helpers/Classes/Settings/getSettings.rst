
.. include:: ../../../../Includes.txt

.. _Settings-getSettings:

==============================================
Settings::getSettings()
==============================================

\\nn\\t3::Settings()->getSettings(``$extensionName = '', $path = ''``);
----------------------------------------------

Fetches the TypoScript setup and the "settings" section there.
Values from the FlexForm are not merged.

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
   

