
.. include:: ../../../../Includes.txt

.. _TCA-getConfig:

==============================================
TCA::getConfig()
==============================================

\\nn\\t3::TCA()->getConfig(``$path = ''``);
----------------------------------------------

Eine Konfiguration aus dem TCA holen für einen Pfad holen.
Liefert eine Referenz zu dem ``config``-Array des ensprechenden Feldes zurück.

.. code-block:: php

	\nn\t3::TCA()->getConfig('tt_content.columns.tx_mask_iconcollection');

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function &getConfig( $path = '' ) {
   	$parts = \nn\t3::Arrays($path)->trimExplode('.');
   	$ref = &$GLOBALS['TCA'];
   	while (count($parts) > 0) {
   		$part = array_shift($parts);
   		$ref = &$ref[$part];
   	}
   	$ref = &$ref['config'];
   	return $ref;
   }
   

