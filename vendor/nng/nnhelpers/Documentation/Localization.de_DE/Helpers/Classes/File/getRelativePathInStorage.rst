
.. include:: ../../../../Includes.txt

.. _File-getRelativePathInStorage:

==============================================
File::getRelativePathInStorage()
==============================================

\\nn\\t3::File()->getRelativePathInStorage(``$file, $storage = NULL``);
----------------------------------------------

Gibt den relativen Pfad einer Datei zur angegebenen Storage wieder.

Beispiel:

.. code-block:: php

	\nn\t3::File()->getRelativePathInStorage('fileadmin/media/bild.jpg', $storage);
	// ==> gibt 'media/bild.jpg' zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRelativePathInStorage($file, $storage = null)
   {
   	$file = $this->stripPathSite($file);
   	$resource = GeneralUtility::makeInstance(ResourceFactory::class)->retrieveFileOrFolderObject($file);
   	if (!$resource) return false;
   	return ltrim($resource->getIdentifier(), '/');
   	// ToDo: Prüfen, ob über ResourceFactory lösbar ResourceFactory::getInstance()->retrieveFileOrFolderObject($filenameOrSysFile->getOriginalResource()->getPublicUrl());
   	$storage = $storage ?: $this->getStorage($file);
   	if (!$storage) return false;
   	$storageConfiguration = $storage->getConfiguration();
   	$storageFolder = $storageConfiguration['basePath'];
   	$basename = substr($file, strlen($storageFolder));
   	if (!file_exists(\nn\t3::Environment()->getPathSite() . $storageFolder . $basename)) return false;
   	return $basename;
   }
   

