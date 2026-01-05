
.. include:: ../../../../Includes.txt

.. _Fal-createSysFile:

==============================================
Fal::createSysFile()
==============================================

\\nn\\t3::Fal()->createSysFile(``$file, $autoCreateStorage = true``);
----------------------------------------------

Erstellt neuen Eintrag in ``sys_file``
Sucht in allen ``sys_file_storage``-Einträgen, ob der Pfad zum $file bereits als Storage existiert.
Falls nicht, wird ein neuer Storage angelegt.

.. code-block:: php

	\nn\t3::Fal()->createSysFile( 'fileadmin/bild.jpg' );
	\nn\t3::Fal()->createSysFile( '/var/www/mysite/fileadmin/bild.jpg' );

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
   

