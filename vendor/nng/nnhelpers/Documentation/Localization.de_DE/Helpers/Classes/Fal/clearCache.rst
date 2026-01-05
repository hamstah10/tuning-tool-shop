
.. include:: ../../../../Includes.txt

.. _Fal-clearCache:

==============================================
Fal::clearCache()
==============================================

\\nn\\t3::Fal()->clearCache(``$filenameOrSysFile = ''``);
----------------------------------------------

Löscht den Cache für die Bildgrößen eines FAL inkl. der umgerechneten Bilder
Wird z.B. der f:image-ViewHelper verwendet, werden alle berechneten Bildgrößen
in der Tabelle sys_file_processedfile gespeichert. Ändert sich das Originalbild,
wird evtl. noch auf ein Bild aus dem Cache zugegriffen.

.. code-block:: php

	\nn\t3::Fal()->clearCache( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->clearCache( $fileReference );
	\nn\t3::Fal()->clearCache( $falFile );

| ``@param $filenameOrSysFile``     FAL oder Pfad (String) zu der Datei
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
   

