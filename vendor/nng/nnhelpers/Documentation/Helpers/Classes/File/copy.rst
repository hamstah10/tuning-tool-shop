
.. include:: ../../../../Includes.txt

.. _File-copy:

==============================================
File::copy()
==============================================

\\nn\\t3::File()->copy(``$src = NULL, $dest = NULL, $renameIfFileExists = true``);
----------------------------------------------

Copies a file.
Returns ``false`` if the file could not be copied.
Returns (new) file name if copying was successful.

.. code-block:: php

	$filename = \nn\t3::File()->copy('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@param string $src`` Path to the source file
| ``@param string $dest`` Path to the destination file
| ``@param boolean $renameIfFileExists`` Rename file if a file with the same name already exists at the destination location
| ``@return string|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function copy($src = null, $dest = null, $renameIfFileExists = true)
   {
   	if (!file_exists($src)) return false;
   	if (!$renameIfFileExists && $this->exists($dest)) return false;
   	$dest = $this->uniqueFilename($dest);
   	$path = pathinfo($dest, PATHINFO_DIRNAME) . '/';
   	// Ordner anlegen, falls noch nicht vorhanden
   	\nn\t3::Storage()->getFolder($path);
   	\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($src, $dest);
   	return $this->exists($dest) ? $dest : false;
   }
   

