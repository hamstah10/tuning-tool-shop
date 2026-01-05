
.. include:: ../../../../Includes.txt

.. _File-getData:

==============================================
File::getData()
==============================================

\\nn\\t3::File()->getData(``$file = ''``);
----------------------------------------------

Imageinfo + EXIF Data für Datei holen.
Sucht auch nach JSON-Datei, die evtl. nach processImage() generiert wurde

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getData($file = '')
   {
   	if (!is_string($file)) {
   		$file = $this->getPath($file);
   	}
   	if (!file_exists($file)) $file = \nn\t3::Environment()->getPathSite() . $file;
   	if (!file_exists($file)) return [];
   	// Dateiname der JSON-Datei: Identisch mit Bildname, aber suffix .json
   	$pathParts = pathinfo($file);
   	$jsonFilename = $pathParts['dirname'] . '/' . $pathParts['filename'] . '.json';
   	// Wurde kein JSON für Datei generiert? Dann über Library EXIF-Daten extrahieren
   	if (!file_exists($jsonFilename)) {
   		return $this->getExifData($file);
   	}
   	// JSON existiert. imageSize trotzdem aktualisieren, weil evtl. processImage() im Einsatz war
   	if ($rawData = file_get_contents($jsonFilename)) {
   		$jsonData = json_decode($rawData, true);
   		return \nn\t3::Arrays($jsonData)->merge($this->getImageSize($file));
   	}
   	return [];
   }
   

