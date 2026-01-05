
.. include:: ../../../../Includes.txt

.. _File-copy:

==============================================
File::copy()
==============================================

\\nn\\t3::File()->copy(``$src = NULL, $dest = NULL, $renameIfFileExists = true``);
----------------------------------------------

Kopiert eine Datei.
Gibt ``false`` zurück, falls die Datei nicht kopiert werden konnte.
Gibt (neuen) Dateinamen zurück, falls das Kopieren erfolgreich war.

.. code-block:: php

	$filename = \nn\t3::File()->copy('fileadmin/bild.jpg', 'fileadmin/bild-kopie.jpg');

| ``@param string $src`` Pfad zur Quelldatei
| ``@param string $dest`` Pfad zur Zieldatei
| ``@param boolean $renameIfFileExists`` Datei umbenennen, falls am Zielort bereits Datei mit gleichem Namen existiert
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
   

