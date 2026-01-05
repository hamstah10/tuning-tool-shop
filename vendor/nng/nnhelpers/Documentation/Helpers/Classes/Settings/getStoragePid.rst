
.. include:: ../../../../Includes.txt

.. _Settings-getStoragePid:

==============================================
Settings::getStoragePid()
==============================================

\\nn\\t3::Settings()->getStoragePid(``$extName = NULL``);
----------------------------------------------

Get current (FIRST) StoragePid for the current plugin.
Saved in the TypoScript setup of the extension under
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm
only happens if ``$extName``is left `` empty``.

.. code-block:: php

	\nn\t3::Settings()->getStoragePid(); // 123
	\nn\t3::Settings()->getStoragePid('nnsite'); // 466

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getStoragePid ( $extName = null )
   {
   	$pids = $this->getStoragePids( $extName );
   	return array_pop( $pids );
   }
   

