
.. include:: ../../../../Includes.txt

.. _Registry-get:

==============================================
Registry::get()
==============================================

\\nn\\t3::Registry()->get(``$extName = '', $path = ''``);
----------------------------------------------

Eine Wert aus der Tabelle sys_registry holen.

.. code-block:: php

	\nn\t3::Registry()->get( 'nnsite', 'lastRun' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get ( $extName = '', $path = '' )
   {
   	$registry = GeneralUtility::makeInstance( CoreRegistry::class );
   	return $registry->get( $extName, $path );
   }
   

