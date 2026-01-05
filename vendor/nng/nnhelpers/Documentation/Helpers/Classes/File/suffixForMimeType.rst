
.. include:: ../../../../Includes.txt

.. _File-suffixForMimeType:

==============================================
File::suffixForMimeType()
==============================================

\\nn\\t3::File()->suffixForMimeType(``$mime = ''``);
----------------------------------------------

Returns the suffix for a specific mime type / content type.
Very reduced version - only a few types covered.
Extensive version: https://bit.ly/3B9KrNA

.. code-block:: php

	\nn\t3::File()->suffixForMimeType('image/jpeg'); => returns 'jpg'

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function suffixForMimeType($mime = '')
   {
   	$mime = array_pop(explode('/', strtolower($mime)));
   	$map = [
   		'jpeg' => 'jpg',
   		'jpg' => 'jpg',
   		'gif' => 'gif',
   		'png' => 'png',
   		'pdf' => 'pdf',
   		'tiff' => 'tif',
   	];
   	foreach ($map as $sword => $suffix) {
   		if (strpos($mime, $sword) !== false) {
   			return $suffix;
   		}
   	}
   	return $mime;
   }
   

