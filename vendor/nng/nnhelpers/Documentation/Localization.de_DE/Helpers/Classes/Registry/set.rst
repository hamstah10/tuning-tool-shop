
.. include:: ../../../../Includes.txt

.. _Registry-set:

==============================================
Registry::set()
==============================================

\\nn\\t3::Registry()->set(``$extName = '', $path = '', $settings = [], $clear = false``);
----------------------------------------------

Einen Wert in der Tabelle sys_registry speichern.
Daten in dieser Tabelle bleiben über die Session hinaus erhalten.
Ein Scheduler-Job kann z.B. speichern, wann er das letzte Mal
ausgeführt wurde.

Arrays werden per default rekursiv zusammengeführt / gemerged:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['eins'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['zwei'=>'2'] );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['eins'=>1, 'zwei'=>2]

Mit ``true`` am Ende werden die vorherigen Werte gelöscht:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['eins'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['zwei'=>'2'], true );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['zwei'=>2]

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
   

