
.. include:: ../../../../Includes.txt

.. _Page-getData:

==============================================
Page::getData()
==============================================

\\nn\\t3::Page()->getData(``$pids = NULL``);
----------------------------------------------

Get data of a page (table ``pages``).

.. code-block:: php

	// data of the current page
	\nn\t3::Page()->getData();
	
	// get data of the page with pid = 123
	\nn\t3::Page()->getData( 123 );
	
	// get data of the pages with pids = 123 and 456. Key of the array = pid
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
   

