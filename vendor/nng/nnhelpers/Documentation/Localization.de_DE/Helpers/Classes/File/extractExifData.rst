
.. include:: ../../../../Includes.txt

.. _File-extractExifData:

==============================================
File::extractExifData()
==============================================

\\nn\\t3::File()->extractExifData(``$filename = ''``);
----------------------------------------------

EXIF Daten für Datei in JSON speichern.

.. code-block:: php

	\nn\t3::File()->extractExifData( 'yellowstone.jpg' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extractExifData($filename = '')
   {
   	$exif = $this->getData($filename);
   	$pathParts = pathinfo($filename);
   	$jsonFilename = $pathParts['dirname'] . '/' . $pathParts['filename'] . '.json';
   	file_put_contents($jsonFilename, json_encode($exif));
   	return $exif;
   }
   

