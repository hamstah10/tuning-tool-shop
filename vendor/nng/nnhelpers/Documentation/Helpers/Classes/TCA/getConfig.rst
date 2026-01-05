
.. include:: ../../../../Includes.txt

.. _TCA-getConfig:

==============================================
TCA::getConfig()
==============================================

\\nn\\t3::TCA()->getConfig(``$path = ''``);
----------------------------------------------

Get a configuration from the TCA for a path.
Returns a reference to the ``config array`` of the corresponding field.

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
   

