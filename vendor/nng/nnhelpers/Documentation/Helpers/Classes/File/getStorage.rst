
.. include:: ../../../../Includes.txt

.. _File-getStorage:

==============================================
File::getStorage()
==============================================

\\nn\\t3::File()->getStorage(``$file, $createIfNotExists = false``);
----------------------------------------------

Finds a matching sys_file_storage for a file or folder path.
To do this, searches through all sys_file_storage entries and compares
whether the basePath of the storage matches the path of the file.

.. code-block:: php

	\nn\t3::File()->getStorage('fileadmin/test/example.txt');
	\nn\t3::File()->getStorage( $falFile );
	\nn\t3::File()->getStorage( $sysFileReference );
	// returns ResourceStorage with basePath "fileadmin/"

| ``@return ResourceStorage``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getStorage($file, $createIfNotExists = false)
   {
   	if (!is_string($file)) {
   		if (\nn\t3::Obj()->isFalFile($file) || \nn\t3::Obj()->isFile($file)) {
   			return $file->getStorage();
   		} else if (\nn\t3::Obj()->isFileReference($file)) {
   			return $file->getOriginalResource()->getStorage();
   		}
   		return false;
   	}
   	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   	try {
   		$resource = $resourceFactory->retrieveFileOrFolderObject($file);
   		if ($resource && $resource->getStorage()?->getUid()) {
   			return $resource->getStorage();
   		}
   	} catch (\Exception $e) {
   		// File/folder not found in any storage
   	}
   	$allowCreateConf = \nn\t3::Settings()->getExtConf('nnhelpers')['autoCreateFilemounts'] ?? true;
   	if (!($allowCreateConf && $createIfNotExists)) {
   		\nn\t3::Exception("nnhelpers: Storage for file {$file} was not found and autocreate was disabled.");
   	}
   	$storageRepository = \nn\t3::Storage();
   	$file = ltrim($file, '/');
   	$dirname = $this->getFolder($file);
   	$uid = $storageRepository->createLocalStorage($dirname . ' (nnhelpers)', $dirname, 'relative');
   	$storageRepository->clearStorageRowCache();
   	$storage = $storageRepository->findByUid($uid);
   	if (!$storage) {
   		\nn\t3::Exception("nnhelpers: Error autocreating storage for file {$file}.");
   	}
   	return $storage;
   }
   

