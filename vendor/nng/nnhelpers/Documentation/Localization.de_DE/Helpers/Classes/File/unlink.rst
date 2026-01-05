
.. include:: ../../../../Includes.txt

.. _File-unlink:

==============================================
File::unlink()
==============================================

\\nn\\t3::File()->unlink(``$file = NULL``);
----------------------------------------------

Löscht eine Datei komplett vom Sever.
Löscht auch alle ``sys_file`` und ``sys_file_references``, die auf die Datei verweisen.
Zur Sicherheit können keine PHP oder HTML Dateien gelöscht werden.

.. code-block:: php

	\nn\t3::File()->unlink('fileadmin/bild.jpg');                  // Pfad zum Bild
	\nn\t3::File()->unlink('/abs/path/to/file/fileadmin/bild.jpg');    // absoluter Pfad zum Bild
	\nn\t3::File()->unlink('1:/my/image.jpg');                     // Combined identifier Schreibweise
	\nn\t3::File()->unlink( $model->getImage() );                 // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->unlink( $falFile );                              // \TYPO3\CMS\Core\Resource\FileReference

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function unlink($file = null)
   {
   	$file = $this->getPublicUrl($file);
   	if (!trim($file)) return false;
   	$file = $this->absPath($this->absPath($file));
   	\nn\t3::Fal()->deleteSysFile($file);
   	if (!$this->exists($file)) return false;
   	if (!$this->isAllowed($file)) return false;
   	@unlink($file);
   	if (file_exists($file)) return false;
   	return true;
   }
   

