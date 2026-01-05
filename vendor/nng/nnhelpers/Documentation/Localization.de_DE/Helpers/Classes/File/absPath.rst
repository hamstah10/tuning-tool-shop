
.. include:: ../../../../Includes.txt

.. _File-absPath:

==============================================
File::absPath()
==============================================

\\nn\\t3::File()->absPath(``$file = NULL, $resolveSymLinks = false``);
----------------------------------------------

Absoluter Pfad zu einer Datei auf dem Server.

Gibt den kompletten Pfad ab der Server-Root zurück, z.B. ab ``/var/www/...``.
Falls der Pfad bereits absolut war, wird er unverändert zurückgegeben.

.. code-block:: php

	\nn\t3::File()->absPath('fileadmin/bild.jpg');                 // => /var/www/website/fileadmin/bild.jpg
	\nn\t3::File()->absPath('/var/www/website/fileadmin/bild.jpg');    // => /var/www/website/fileadmin/bild.jpg
	\nn\t3::File()->absPath('EXT:nnhelpers');                      // => /var/www/website/typo3conf/ext/nnhelpers/

Außer dem Dateipfad als String können auch alle denkbaren Objekte übergeben werden:

.. code-block:: php

	// \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->absPath( $folderObject );    => /var/www/website/fileadmin/bild.jpg
	
	// \TYPO3\CMS\Core\Resource\File
	\nn\t3::File()->absPath( $fileObject );      => /var/www/website/fileadmin/bild.jpg
	
	// \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->absPath( $fileReference );   => /var/www/website/fileadmin/bild.jpg

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:file.absPath(file:'pfad/zum/bild.jpg')}

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function absPath($file = null, $resolveSymLinks = false)
   {
   	if (\nn\t3::Obj()->isFileReference($file)) {
   		$file = $file->getOriginalResource()->getOriginalFile();
   		return $file->getForLocalProcessing(false);
   	}
   	if (\nn\t3::Obj()->isFile($file)) {
   		$path = $file->getIdentifier();
   		$folder = $file->getStorage()->getConfiguration()['basePath'];
   		return rtrim($folder, '/') . $path;
   	}
   	if (!is_string($file)) {
   		$file = $this->getPublicUrl($file);
   	}
   	if (strpos($file, sys_get_temp_dir()) !== false) {
   		return $file;
   	}
   	if (strpos($file, '/fileadmin') === 0) {
   		$file = ltrim($file, '/');
   	}
   	$file = $this->stripBaseUrl($file);
   	// Prüfen, ob ein Symlink im Spiel ist
   	if ($resolveSymLinks && is_link(dirname($file))) {
   		$link = readlink(dirname($file));
   		$file = realpath(dirname($file) . '/' . $link) . '/' . basename($file);
   	}
   	$file = $this->resolvePathPrefixes($file);
   	$file = $this->normalizePath($file);
   	return GeneralUtility::getFileAbsFileName($file);
   }
   

