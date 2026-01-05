
.. include:: ../../../../Includes.txt

.. _Fal-process:

==============================================
Fal::process()
==============================================

\\nn\\t3::Fal()->process(``$fileObj = '', $processing = []``);
----------------------------------------------

Calculates an image via ``maxWidth``, ``maxHeight``, ``cropVariant`` etc.
Returns URI to the image as a string. Helpful for calculating thumbnails in the backend.
Alias to ``\nn\t3::File()->process()``

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/images/portrait.jpg', ['maxWidth'=>200] );
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
   

