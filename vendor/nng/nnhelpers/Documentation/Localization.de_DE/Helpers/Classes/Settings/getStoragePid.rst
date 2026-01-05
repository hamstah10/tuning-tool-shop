
.. include:: ../../../../Includes.txt

.. _Settings-getStoragePid:

==============================================
Settings::getStoragePid()
==============================================

\\nn\\t3::Settings()->getStoragePid(``$extName = NULL``);
----------------------------------------------

Aktuelle (ERSTE) StoragePid für das aktuelle Plugin holen.
Gespeichert im TypoScript-Setup der Extension unter
| ``plugin.tx_extname.persistence.storagePid`` bzw. im
FlexForm des Plugins auf der jeweiligen Seite.

WICHTIG: Merge mit gewählter StoragePID aus dem FlexForm
passiert nur, wenn ``$extName``leer gelassen wird.

.. code-block:: php

	\nn\t3::Settings()->getStoragePid();         // 123
	\nn\t3::Settings()->getStoragePid('nnsite');   // 466

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getStoragePid ( $extName = null )
   {
   	$pids = $this->getStoragePids( $extName );
   	return array_pop( $pids );
   }
   

