
.. include:: ../../../../Includes.txt

.. _Storage-getFolder:

==============================================
Storage::getFolder()
==============================================

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
----------------------------------------------

Returns the \Folder object for a target folder (or file) within a storage.
Creates a folder if it does not yet exist

Examples:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/example.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==> returns \Folder object for the folder 'test/'

| ``@return Folder``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFolder( $file, $storage = null )
   {
   	$storage = $storage ?: \nn\t3::File()->getStorage( $file );
   	if (!$storage) return false;
   	$storageConfiguration = $storage->getConfiguration();
   	$dirname = \nn\t3::File()->getFolder($file);
   	$folderPathInStorage = substr($dirname, strlen($storageConfiguration['basePath']));
   	// Ordner existiert bereits
   	if ($storage->hasFolder($folderPathInStorage)) return $storage->getFolder( $folderPathInStorage );
   	// Ordner muss angelegt werden
   	return $storage->createFolder($folderPathInStorage);
   }
   

