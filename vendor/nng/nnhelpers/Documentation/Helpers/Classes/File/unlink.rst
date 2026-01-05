
.. include:: ../../../../Includes.txt

.. _File-unlink:

==============================================
File::unlink()
==============================================

\\nn\\t3::File()->unlink(``$file = NULL``);
----------------------------------------------

Deletes a file completely from the server.
Also deletes all ``sys_file`` and ``sys_file_references`` that refer to the file.
For security reasons, no PHP or HTML files can be deleted.

.. code-block:: php

	\nn\t3::File()->unlink('fileadmin/image.jpg'); // Path to the image
	\nn\t3::File()->unlink('/abs/path/to/file/fileadmin/image.jpg'); // absolute path to the image
	\nn\t3::File()->unlink('1:/my/image.jpg'); // Combined identifier notation
	\nn\t3::File()->unlink( $model->getImage() ); // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->unlink( $falFile ); // \TYPO3\CMS\Core\Resource\FileReference

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
   

