
.. include:: ../../../../Includes.txt

.. _File-process:

==============================================
File::process()
==============================================

\\nn\\t3::File()->process(``$fileObj = '', $processing = [], $returnProcessedImage = false``);
----------------------------------------------

Berechnet ein Bild über ``maxWidth``, ``maxHeight`` etc.
Einfache Version von ``\nn\t3::File()->processImage()``
Kann verwendet werden, wenn es nur um das Generieren von verkleinerten Bilder geht
ohne Berücksichtigung von Korrekturen der Kamera-Ausrichtung etc.

Da die Crop-Einstellungen in FileReference und nicht File gespeichert sind,
funktioniert ``cropVariant`` nur bei Übergabe einer ``FileReference``.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200, 'absolute'=>true] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

Mit dem Parameter ``$returnProcessedImage = true`` wird nicht der Dateipfad zum neuen Bild
sondern das processedImage-Object zurückgegeben.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200], true );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function process($fileObj = '', $processing = [], $returnProcessedImage = false)
   {
   	$filename = '';
   	$cropString = '';
   	$imageService = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Service\ImageService::class);
   	if ($fileObj instanceof \TYPO3\CMS\Core\Resource\FileReference) {
   		$fileObj = \nn\t3::Convert($fileObj)->toFileReference();
   	}
   	if ($fileObj instanceof \TYPO3\CMS\Core\Resource\File) {
   		// sys_file-Object
   		$filename = $fileObj->getPublicUrl();
   	} else if (is_a($fileObj, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class)) {
   		// sys_file_reference-Object
   		if (method_exists($fileObj, 'getProperty')) {
   			$cropString = $fileObj->getProperty('crop');
   		} else if ($originalResource = $fileObj->getOriginalResource()) {
   			$cropString = $originalResource->getProperty('crop');
   		}
   		$image = $fileObj->getOriginalResource();
   	} else if (is_string($fileObj) && strpos($fileObj, ':/') !== false) {
   		// String mit file_storage-Angabe (1:/uploads/test.jpg)
   		$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   		$file = $resourceFactory->getFileObjectFromCombinedIdentifier($fileObj);
   		$filename = $file->getPublicUrl();
   	} else if (is_string($fileObj)) {
   		// String (fileadmin/uploads/test.jpg)
   		$filename = $fileObj;
   	}
   	if ($filename) {
   		$image = $imageService->getImage($filename, null, false);
   	}
   	if ($image) {
   		$cropVariantCollection = CropVariantCollection::create((string)$cropString);
   		$cropVariant = $processing['cropVariant'] ?? 'default';
   		$cropArea = $cropVariantCollection->getCropArea($cropVariant);
   		$processing['crop'] = $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image);
   		$processedImage = $imageService->applyProcessingInstructions($image, $processing);
   		if ($returnProcessedImage) return $processedImage;
   		return $imageService->getImageUri($processedImage, $processing['absolute'] ?? false);
   	}
   	return false;
   }
   

