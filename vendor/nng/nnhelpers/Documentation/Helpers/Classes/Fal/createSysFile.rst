
.. include:: ../../../../Includes.txt

.. _Fal-createSysFile:

==============================================
Fal::createSysFile()
==============================================

\\nn\\t3::Fal()->createSysFile(``$file, $autoCreateStorage = true``);
----------------------------------------------

Creates new entry in ``sys_file``
Searches all ``sys_file_storage entries`` to see whether the path to the $file already exists as storage.
If not, a new storage is created.

.. code-block:: php

	\nn\t3::Fal()->createSysFile( 'fileadmin/image.jpg' );
	\nn\t3::Fal()->createSysFile( '/var/www/mysite/fileadmin/image.jpg' );

| ``@return false|\TYPO3\CMS\Core\Resource\File``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createSysFile ( $file, $autoCreateStorage = true )
   {
   	$file = \nn\t3::File()->stripPathSite( $file );
   	$storage = \nn\t3::File()->getStorage( $file, $autoCreateStorage );
   	if (!$storage) return false;
   	$fileRepository = \nn\t3::injectClass( FileRepository::class );
   	$storageConfiguration = $storage->getConfiguration();
   	$storageFolder = $storageConfiguration['basePath'];
   	$basename = substr( $file, strlen($storageFolder) );
   	$sysFile = $storage->getFile($basename);
   	// @return \TYPO3\CMS\Core\Resource\File
   	$file = GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($sysFile->getUid());
   	return $file;
   }
   

