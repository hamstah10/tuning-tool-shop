
.. include:: ../../../../Includes.txt

.. _Storage-getFolder:

==============================================
Storage::getFolder()
==============================================

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
----------------------------------------------

Gibt den \Folder-Object für einen Zielordner (oder Datei) innerhalb einer Storage zurück.
Legt Ordner an, falls er noch nicht existiert

Beispiele:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/beispiel.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==>  gibt \Folder-Object für den Ordner 'test/' zurück

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
   

