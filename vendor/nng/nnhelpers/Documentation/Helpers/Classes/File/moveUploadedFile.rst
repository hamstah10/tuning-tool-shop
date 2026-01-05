
.. include:: ../../../../Includes.txt

.. _File-moveUploadedFile:

==============================================
File::moveUploadedFile()
==============================================

\\nn\\t3::File()->moveUploadedFile(``$src = NULL, $dest = NULL``);
----------------------------------------------

Move an upload file to the target directory.

Can be the absolute path to the tmp file of the upload Ã¢ or a ``TYPO3\CMS\Core\Http\UploadedFile``,
which can be retrieved in the controller via ``$this->request->getUploadedFiles()``.

.. code-block:: php

	\nn\t3::File()->moveUploadedFile('/tmp/xjauGSaudsha', 'fileadmin/image-copy.jpg');
	\nn\t3::File()->moveUploadedFile( $fileObj, 'fileadmin/image-copy.jpg');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function moveUploadedFile($src = null, $dest = null)
   {
   	$dest = $this->uniqueFilename($this->absPath($dest));
   	if (!$this->isAllowed($dest)) {
   		\nn\t3::Exception('\nn\t3::File()->moveUploadedFile() :: Filetype not allowed.');
   		return false;
   	}
   	if (!is_string($src) && is_a($src, \TYPO3\CMS\Core\Http\UploadedFile::class)) {
   		if ($stream = $src->getStream()) {
   			$handle = fopen($dest, 'wb+');
   			if ($handle === false) return false;
   			$stream->rewind();
   			while (!$stream->eof()) {
   				$bytes = $stream->read(4096);
   				fwrite($handle, $bytes);
   			}
   			fclose($handle);
   		}
   	} else {
   		$src = $this->absPath($src);
   		move_uploaded_file($src, $dest);
   	}
   	if (file_exists($dest)) {
   		return $dest;
   	}
   	return false;
   }
   

