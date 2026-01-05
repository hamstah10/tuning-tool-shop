
.. include:: ../../../../Includes.txt

.. _Tsfe-cObjGetSingle:

==============================================
Tsfe::cObjGetSingle()
==============================================

\\nn\\t3::Tsfe()->cObjGetSingle(``$type = '', $conf = []``);
----------------------------------------------

Ein TypoScript-Object rendern.
Früher: ``$GLOBALS['TSFE']->cObj->cObjGetSingle()``

.. code-block:: php

	\nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'bild.jpg', 'file.'=>['maxWidth'=>200]] )

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function cObjGetSingle( $type = '', $conf = [] )
   {
   	try {
   		$content = $this->cObj()->cObjGetSingle( $type, $conf );
   		return $content;
   	} catch (\Error $e) {
   		return 'ERROR: ' . $e->getMessage();
   	}
   }
   

