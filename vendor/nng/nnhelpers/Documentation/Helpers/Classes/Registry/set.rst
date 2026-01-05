
.. include:: ../../../../Includes.txt

.. _Registry-set:

==============================================
Registry::set()
==============================================

\\nn\\t3::Registry()->set(``$extName = '', $path = '', $settings = [], $clear = false``);
----------------------------------------------

Save a value in the sys_registry table.
Data in this table is retained beyond the session.
For example, a scheduler job can save when it was last executed.
was executed.

Arrays are recursively merged / merged by default:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['one'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['two'=>'2'] );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['one'=>1, 'two'=>2]

With ``true`` at the end, the previous values are deleted:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['one'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['two'=>'2'], true );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['two'=>2]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function set ( $extName = '', $path = '', $settings = [], $clear = false )
   {
   	$registry = GeneralUtility::makeInstance( CoreRegistry::class );
   	if (!$clear && is_array($settings)) {
   		$curSettings = $this->get( $extName, $path ) ?: [];
   		$settings = \nn\t3::Arrays( $curSettings )->merge( $settings, true, true );
   	}
   	$registry->set( $extName,  $path, $settings );
   	return $settings;
   }
   

