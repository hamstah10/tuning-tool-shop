
.. include:: ../../../../Includes.txt

.. _Settings-get:

==============================================
Settings::get()
==============================================

\\nn\\t3::Settings()->get(``$extensionName = '', $path = ''``);
----------------------------------------------

Fetches the TypoScript setup and the "settings" section there.
Values from the FlexForm are not merged.
Alias to ``\nn\t3::Settings()->getSettings()``.

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
   

