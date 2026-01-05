
.. include:: ../../../../Includes.txt

.. _File-getPath:

==============================================
File::getPath()
==============================================

\\nn\\t3::File()->getPath(``$file, $storage = NULL, $absolute = true``);
----------------------------------------------

Gibt den Pfad einer Datei anhand eines Dateinamens und der Storage wieder.
Beispiel:

.. code-block:: php

	\nn\t3::File()->getPath('media/bild.jpg', $storage);
	// ==> gibt '/var/www/.../fileadmin/media/bild.jpg' zurück
	\nn\t3::File()->getPath('fileadmin/media/bild.jpg');
	// ==> gibt '/var/www/.../fileadmin/media/bild.jpg' zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPath($file, $storage = null, $absolute = true)
   {
   	// ToDo: Prüfen, ob über ResourceFactory lösbar ResourceFactory::getInstance()->retrieveFileOrFolderObject($filenameOrSysFile->getOriginalResource()->getPublicUrl());
   	if (is_string($file)) {
   		$file = ltrim($file, '/');
   		$storage = $storage ?: $this->getStorage($file);
   		if (!$storage) return false;
   		$storageConfiguration = $storage->getConfiguration();
   		$storageFolder = $storageConfiguration['basePath'];
   	} else {
   		$file = $this->getPublicUrl($file);
   		$storageFolder = '';
   	}
   	$relPath = $storageFolder . $file;
   	$absPath = \nn\t3::Environment()->getPathSite() . $storageFolder . $file;
   	if (file_exists($absPath)) return $absolute ? $absPath : $relPath;
   	return false;
   }
   

