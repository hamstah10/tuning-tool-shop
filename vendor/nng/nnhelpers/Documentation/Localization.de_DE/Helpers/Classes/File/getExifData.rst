
.. include:: ../../../../Includes.txt

.. _File-getExifData:

==============================================
File::getExifData()
==============================================

\\nn\\t3::File()->getExifData(``$filename = ''``);
----------------------------------------------

ALLE EXIF Daten für Datei holen.

.. code-block:: php

	\nn\t3::File()->getExif( 'yellowstone.jpg' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getExifData($filename = '')
   {
   	return array_merge(
   		$this->getImageSize($filename),
   		$this->getImageData($filename),
   		$this->getLocationData($filename)
   	);
   }
   

