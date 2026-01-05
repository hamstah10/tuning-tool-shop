
.. include:: ../../../../Includes.txt

.. _Page-getData:

==============================================
Page::getData()
==============================================

\\nn\\t3::Page()->getData(``$pids = NULL``);
----------------------------------------------

Daten einer Seiten holen (Tabelle ``pages``).

.. code-block:: php

	// data der aktuellen Seite
	\nn\t3::Page()->getData();
	
	// data der Seite mit pid = 123 holen
	\nn\t3::Page()->getData( 123 );
	
	// data der Seiten mit pids = 123 und 456 holen. Key des Arrays = pid
	\nn\t3::Page()->getData( [123, 456] );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getData ( $pids = null ) {
   	if (!$pids) $pids = $this->getPid( $pids );
   	$returnArray = is_array( $pids );
   	if (!$returnArray) $pids = [$pids];
   	if (\nn\t3::Environment()->isFrontend()) {
   		$pages = [];
   		foreach ($pids as $pid) {
   			$pages[$pid] = $this->get( $pid );
   		}
   		if (!$returnArray) $pages = array_pop( $pages );
   		return $pages;
   	}
   	return [];
   }
   

