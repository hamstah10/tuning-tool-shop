
.. include:: ../../../../Includes.txt

.. _Settings-getStoragePids:

==============================================
Settings::getStoragePids()
==============================================

\\nn\\t3::Settings()->getStoragePids(``$extName = NULL, $recursive = 0``);
----------------------------------------------

Get ALL storagePids for the current plugin.
Saved as a comma-separated list in the TypoScript setup of the extension under
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm
only happens if ``$extName``is left `` empty``.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(); // [123, 466]
	\nn\t3::Settings()->getStoragePids('nnsite'); // [123, 466]

Also get the child-PageUids?
| ``true`` takes the value for "Recursive" from the FlexForm or from the
TypoScript of the extension of ``plugin.tx_extname.persistence.recursive``

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(true); // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', true); // [123, 466, 124, 467, 468]

Alternatively, a numerical value can also be passed for the depth / recursion
can also be passed.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(2); // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', 2); // [123, 466, 124, 467, 468]

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
   

