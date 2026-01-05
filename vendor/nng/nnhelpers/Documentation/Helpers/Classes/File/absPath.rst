
.. include:: ../../../../Includes.txt

.. _File-absPath:

==============================================
File::absPath()
==============================================

\\nn\\t3::File()->absPath(``$file = NULL, $resolveSymLinks = false``);
----------------------------------------------

Absolute path to a file on the server.

Returns the complete path from the server root, e.g. from ``/var/www/....``
If the path was already absolute, it is returned unchanged.

.. code-block:: php

	\nn\t3::File()->absPath('fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('/var/www/website/fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('EXT:nnhelpers'); // => /var/www/website/typo3conf/ext/nnhelpers/

In addition to the file path as a string, all conceivable objects can also be transferred:

.. code-block:: php

	// \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->absPath( $folderObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Core\Resource\File
	\nn\t3::File()->absPath( $fileObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->absPath( $fileReference ); => /var/www/website/fileadmin/image.jpg

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:file.absPath(file:'path/to/image.jpg')}

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
   

