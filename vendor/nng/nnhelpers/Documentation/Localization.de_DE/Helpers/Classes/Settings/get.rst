
.. include:: ../../../../Includes.txt

.. _Settings-get:

==============================================
Settings::get()
==============================================

\\nn\\t3::Settings()->get(``$extensionName = '', $path = ''``);
----------------------------------------------

Holt das TypoScript-Setup und dort den Abschnitt "settings".
Werte aus dem FlexForm werden dabei nicht gemerged.
Alias zu ``\nn\t3::Settings()->getSettings()``.

.. code-block:: php

	\nn\t3::Settings()->get( 'nnsite' );
	\nn\t3::Settings()->get( 'nnsite', 'path.in.settings' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $extensionName = '', $path = '' )
   {
   	return $this->getSettings( $extensionName, $path );
   }
   

