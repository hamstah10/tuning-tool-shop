
.. include:: ../../../../Includes.txt

.. _Fal-createFalFile:

==============================================
Fal::createFalFile()
==============================================

\\nn\\t3::Fal()->createFalFile(``$storageConfig, $srcFile, $keepSrcFile = false, $forceCreateNew = false``);
----------------------------------------------

Creates a \File (FAL) object (sys_file)

\nn\t3::Fal()->createFalFile( $storageConfig, $srcFile, $keepSrcFile, $forceCreateNew );

| ``@param string $storageConfig`` Path/folder in which the FAL file is to be saved (e.g. 'fileadmin/projectdata/')
| ``@param string $srcFile`` Source file to be converted to FAL (e.g. 'uploads/tx_nnfesubmit/example.jpg')
Can also be URL to YouTube/Vimeo video (e.g. https://www. youtube.com/watch?v=7Bb5jXhwnRY)
| ``@param boolean $keepSrcFile`` Copy source file only, do not move?
| ``@param boolean $forceCreateNew`` Should a new file always be created? If not, it may return an existing file object

| ``@return \Nng\Nnhelpers\Domain\Model\File|\TYPO3\CMS\Core\Resource\File|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createFalFile ( $storageConfig, $srcFile, $keepSrcFile = false, $forceCreateNew = false )
   {
   	$fileHelper = \nn\t3::File();
   	$fileRepository = \nn\t3::injectClass( FileRepository::class );
   	$srcFile = $fileHelper->stripBaseUrl( $srcFile );
   	$isExternalMedia = strpos( $srcFile, 'http://') !== false || strpos( $srcFile, 'https://') !== false;
   	if (!$storageConfig) {
   		$storageConfig = $isExternalMedia ? 'fileadmin/videos/' : $srcFile;
   	}
   	// Absoluter Pfad zur Quell-Datei ('/var/www/website/uploads/bild.jpg')
   	$absSrcFile = $fileHelper->absPath( $srcFile );
   	// Keine externe URL (YouTube...) und Datei existiert nicht? Dann abbrechen!
   	if (!$isExternalMedia && !$fileHelper->exists($srcFile)) {
   		return false;
   	}
   	// Object, Storage-Model für Zielverzeichnis (z.B. Object für 'fileadmin/' wenn $storageConfig = 'fileadmin/test/was/')
   	$storage = $fileHelper->getStorage($storageConfig, true);
   	// Object, relativer Unterordner innerhalb der Storage, (z.B. Object für 'test/was/' wenn $storageConfig = 'fileadmin/test/was/')
   	$subfolderInStorage = \nn\t3::Storage()->getFolder($storageConfig, $storage);
   	// String, absoluter Pfad zum Zielverzeichnis
   	$absDestFolderPath = $fileHelper->absPath( $subfolderInStorage );
   	// Dateiname, ohne Pfad ('fileadmin/test/bild.jpg' => 'bild.jpg')
   	$srcFileBaseName = basename($srcFile);
   	if (!$forceCreateNew && $storage->hasFileInFolder( $srcFileBaseName, $subfolderInStorage )) {
   		$existingFile = $storage->getFileInFolder( $srcFileBaseName, $subfolderInStorage );
   		// @returns \TYPO3\CMS\Core\Resource\File
   		return $existingFile;
   	}
   	if ($isExternalMedia) {
   		// YouTube und Vimeo-Videos: Physische lokale .youtube/.vimeo-Datei anlegen
   		$helper = \nn\t3::injectClass( OnlineMediaHelperRegistry::class );
   		// \TYPO3\CMS\Core\Resource\File
   		$newFileObject = $helper->transformUrlToFile( $srcFile, $subfolderInStorage );
   	} else {
   		// "Normale" Datei: Datei in Ordner kopieren und FAL erstellen
   		// Name der Datei im Zielverzeichnis
   		$absTmpName = $absDestFolderPath . $srcFileBaseName;
   		// Kopieren
   		if ($forceCreateNew) {
   			$success = $fileHelper->copy( $absSrcFile, $absTmpName, $forceCreateNew );
   			$absTmpName = $success;
   		} else {
   			if ($keepSrcFile) {
   				$success = $fileHelper->copy( $absSrcFile, $absTmpName );
   				$absTmpName = $success;
   			} else {
   				$success = $fileHelper->move( $absSrcFile, $absTmpName );
   			}
   		}
   		if (!$success) return false;
   		// Nutze die File-Indexer-Funktion, um die temporäre Datei in der Tabelle sys_file einzufügen
   		$this->clearCache($absTmpName);
   		// String, relativer Pfad der Datei innerhalb der Storage. Ermittelt selbstständig die passende Storage ()
   		$relPathInStorage = $fileHelper->getRelativePathInStorage( $absTmpName );
   		// File-Object für tmp-Datei holen
   		$tmpFileObject = $storage->getFile($relPathInStorage);
   		if (!$tmpFileObject) return false;
   		// $newFileObject = $tmpFileObject->moveTo($subfolderInStorage, $srcFileBaseName, DuplicationBehavior::RENAME);
   		$newFileObject = $tmpFileObject;
   	}
   	if (!$newFileObject) return false;
   	// Exif-Daten für Datei ermitteln
   	if ($exif = $fileHelper->getExifData( $srcFile )) {
   		\nn\t3::Db()->update('sys_file', ['exif'=>json_encode($exif)], $newFileObject->getUid());
   	}
   	// @returns \TYPO3\CMS\Core\Resource\File
   	return $newFileObject;
   }
   

