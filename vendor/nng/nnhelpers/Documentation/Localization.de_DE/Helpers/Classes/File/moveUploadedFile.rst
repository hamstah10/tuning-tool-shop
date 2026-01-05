
.. include:: ../../../../Includes.txt

.. _File-moveUploadedFile:

==============================================
File::moveUploadedFile()
==============================================

\\nn\\t3::File()->moveUploadedFile(``$src = NULL, $dest = NULL``);
----------------------------------------------

Eine Upload-Datei ins Zielverzeichnis verschieben.

Kann absoluter Pfad zur tmp-Datei des Uploads sein – oder ein ``TYPO3\CMS\Core\Http\UploadedFile``,
das sich im Controller über ``$this->request->getUploadedFiles()`` holen lässt.

.. code-block:: php

	\nn\t3::File()->moveUploadedFile('/tmp/xjauGSaudsha', 'fileadmin/bild-kopie.jpg');
	\nn\t3::File()->moveUploadedFile( $fileObj, 'fileadmin/bild-kopie.jpg');

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
   

