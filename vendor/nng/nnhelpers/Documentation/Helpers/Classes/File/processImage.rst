
.. include:: ../../../../Includes.txt

.. _File-processImage:

==============================================
File::processImage()
==============================================

\\nn\\t3::File()->processImage(``$filenameOrSysFile = '', $processing = []``);
----------------------------------------------

Can be called directly after upload_copy_move().
Corrects the orientation of the image, which may have been saved in EXIF data.
Simply use the method ``\nn\t3::File()->process()`` for the ``maxWidth statement``.

Instructions for $processing:

| ``correctOrientation`` => Correct rotation (e.g. because photo was uploaded from smartphone)

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function processImage($filenameOrSysFile = '', $processing = [])
   {
   	if (is_string($filenameOrSysFile)) {
   		if ($falFile = \nn\t3::Fal()->getFalFile($filenameOrSysFile)) {
   			$filenameOrSysFile = $falFile;
   		}
   	}
   	// Bereits berechnete Bildgrößen löschen
   	\nn\t3::Fal()->clearCache($filenameOrSysFile);
   	if (is_string($filenameOrSysFile)) {
   		$filename = $filenameOrSysFile;
   	} else if (is_a($filenameOrSysFile, \TYPO3\CMS\Core\Resource\File::class)) {
   		$filename = $filenameOrSysFile->getPublicUrl();
   	}
   	if (!trim($filename)) return;
   	$pathSite = \nn\t3::Environment()->getPathSite();
   	$processing = \nn\t3::Arrays([
   		'correctOrientation' => true,
   		'maxWidth' => 6000,
   		'maxHeight' => 6000,
   	])->merge($processing);
   	$processingInstructions = [
   		'file' => $filename,
   		'file.' => [],
   	];
   	if ($maxWidth = $processing['maxWidth']) {
   		$processingInstructions['file.']['maxW'] = $maxWidth;
   	}
   	if ($maxHeight = $processing['maxHeight']) {
   		$processingInstructions['file.']['maxH'] = $maxHeight;
   	}
   	// EXIF-Daten vorhanden? Dann als JSON speichern, weil sie nach dem Processing verloren gehen würden.
   	if (is_object($filenameOrSysFile)) {
   		$uid = $filenameOrSysFile->getUid();
   		$exif = \nn\t3::Db()->findByUid('sys_file', $uid)['exif'] ?? [];
   	} else if ($exif = $this->getImageData($filename)) {
   		$exif = $this->extractExifData($filename);
   	}
   	// $exif['im'] enthält z.B. "-rotate 90" als ImageMagick Anweisung
   	if ($exif['im'] && $processing['correctOrientation']) {
   		$processingInstructions['file.']['params'] = $exif['im'];
   	}
   	$processedImageFilename = \nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', $processingInstructions);
   	if ($processedImageFilename) {
   		\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($pathSite . $processedImageFilename, $pathSite . $filename);
   	}
   	$exif = array_merge($this->getData($filename), ['file' => $filename]);
   	// Update der Meta-Daten für das Bild
   	if (is_object($filenameOrSysFile)) {
   		\nn\t3::Fal()->updateMetaData($filenameOrSysFile);
   	}
   	return $exif;
   }
   

