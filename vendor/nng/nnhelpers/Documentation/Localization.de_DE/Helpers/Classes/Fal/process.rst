
.. include:: ../../../../Includes.txt

.. _Fal-process:

==============================================
Fal::process()
==============================================

\\nn\\t3::Fal()->process(``$fileObj = '', $processing = []``);
----------------------------------------------

Berechnet ein Bild über ``maxWidth``, ``maxHeight``, ``cropVariant`` etc.
Gibt URI zum Bild als String zurück. Hilfreich bei der Berechnung von Thumbnails im Backend.
Alias zu ``\nn\t3::File()->process()``

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function process ( $fileObj = '', $processing = [] )
   {
   	return \nn\t3::File()->process( $fileObj, $processing );
   }
   

