
.. include:: ../../../../Includes.txt

.. _Fal-clearCache:

==============================================
Fal::clearCache()
==============================================

\\nn\\t3::Fal()->clearCache(``$filenameOrSysFile = ''``);
----------------------------------------------

Deletes the cache for the image sizes of a FAL including the converted images
If, for example, the f:image-ViewHelper is used, all calculated image sizes are
are saved in the sys_file_processedfile table. If the original image changes,
an image from the cache may still be accessed.

.. code-block:: php

	\nn\t3::Fal()->clearCache( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->clearCache( $fileReference );
	\nn\t3::Fal()->clearCache( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearCache ( $filenameOrSysFile = '' )
   {
   	if (is_string($filenameOrSysFile)) {
   		if ($falFile = $this->getFalFile( $filenameOrSysFile )) {
   			$filenameOrSysFile = $falFile;
   		}
   	}
   	$processedFileRepository = \nn\t3::injectClass( ProcessedFileRepository::class );
   	if (is_string($filenameOrSysFile)) return;
   	if (is_a($filenameOrSysFile, \TYPO3\CMS\Extbase\Domain\Model\File::class)) {
   		$filenameOrSysFile = $filenameOrSysFile->getOriginalResource();
   	}
   	if ($processedFiles = $processedFileRepository->findAllByOriginalFile( $filenameOrSysFile )) {
   		foreach ($processedFiles as $file) {
   			$file->delete( true );
   			\nn\t3::Db()->delete('sys_file_processedfile', $file->getUid());
   		}
   	}
   }
   

