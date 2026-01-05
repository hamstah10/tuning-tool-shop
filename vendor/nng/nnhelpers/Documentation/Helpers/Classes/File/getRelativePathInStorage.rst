
.. include:: ../../../../Includes.txt

.. _File-getRelativePathInStorage:

==============================================
File::getRelativePathInStorage()
==============================================

\\nn\\t3::File()->getRelativePathInStorage(``$file, $storage = NULL``);
----------------------------------------------

Returns the relative path of a file to the specified storage.

Example:

.. code-block:: php

	\nn\t3::File()->getRelativePathInStorage('fileadmin/media/image.jpg', $storage);
	// ==> returns 'media/image.jpg'

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
   

