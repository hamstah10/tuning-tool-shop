
.. include:: ../../../../Includes.txt

.. _Settings-getStoragePids:

==============================================
Settings::getStoragePids()
==============================================

\\nn\\t3::Settings()->getStoragePids(``$extName = NULL, $recursive = 0``);
----------------------------------------------

ALLE storagePids für das aktuelle Plugin holen.
Gespeichert als komma-separierte Liste im TypoScript-Setup der Extension unter
| ``plugin.tx_extname.persistence.storagePid`` bzw. im
FlexForm des Plugins auf der jeweiligen Seite.

WICHTIG: Merge mit gewählter StoragePID aus dem FlexForm
passiert nur, wenn ``$extName``leer gelassen wird.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids();                    // [123, 466]
	\nn\t3::Settings()->getStoragePids('nnsite');          // [123, 466]

Auch die child-PageUids holen?
| ``true`` nimmt den Wert für "Rekursiv" aus dem FlexForm bzw. aus dem
TypoScript der Extension von ``plugin.tx_extname.persistence.recursive``

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(true);                // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', true);        // [123, 466, 124, 467, 468]

Alternativ kann für die Tiefe / Rekursion auch ein numerischer Wert
übergeben werden.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(2);               // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', 2);       // [123, 466, 124, 467, 468]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getStoragePids ( $extName = null, $recursive = 0 )
   {
   	// numerischer Wert: ->getStoragePids( 3 ) oder Boolean: ->getStoragePids( true )
   	if (is_numeric($extName) || $extName === true ) {
   		$recursive = $extName;
   		$extName = null;
   	}
   	// $cObjData nur holen, falls kein extName angegeben wurde
   	$cObjData = $extName === null ? [] : \nn\t3::Tsfe()->cObjData();
   	$setup = $this->getPlugin( $extName  );
   	// Wenn `recursive = true`, dann Wert aus FlexForm bzw. TypoScript nehmen
   	$recursive = $recursive === true ? ($cObjData['recursive'] ?? $setup['persistence']['recursive'] ?? false) : $recursive;
   	$pids = $cObjData['pages'] ?? $setup['persistence']['storagePid'] ?? '';
   	$pids = \nn\t3::Arrays( $pids )->intExplode();
   	// Child-Uids ergänzen?
   	$childList = $recursive > 0 ? \nn\t3::Page()->getChildPids( $pids, $recursive ) : [];
   	return array_merge( $pids, $childList );
   }
   

