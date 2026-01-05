
.. include:: ../../../../Includes.txt

.. _File-getPath:

==============================================
File::getPath()
==============================================

\\nn\\t3::File()->getPath(``$file, $storage = NULL, $absolute = true``);
----------------------------------------------

Returns the path of a file using a file name and the storage.
Example:

.. code-block:: php

	\nn\t3::File()->getPath('media/image.jpg', $storage);
	// ==> returns '/var/www/.../fileadmin/media/image.jpg'
	\nn\t3::File()->getPath('fileadmin/media/image.jpg');
	// ==> returns '/var/www/.../fileadmin/media/image.jpg'

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
   

