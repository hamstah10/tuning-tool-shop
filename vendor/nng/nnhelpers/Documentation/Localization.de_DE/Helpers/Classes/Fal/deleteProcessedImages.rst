
.. include:: ../../../../Includes.txt

.. _Fal-deleteProcessedImages:

==============================================
Fal::deleteProcessedImages()
==============================================

\\nn\\t3::Fal()->deleteProcessedImages(``$sysFile = ''``);
----------------------------------------------

Löscht alle physischen Thumbnail-Dateien, die für ein Bild generiert wurden inkl.
der Datensätze in der Tabelle ``sys_file_processedfile``.

Das Ursprungsbild, das als Argument ``$path`` übergeben wurde, wird dabei nicht gelöscht.
Das Ganze erzwingt das Neugenerieren der Thumbnails für ein Bild, falls sich z.B. das
Quellbild geändert hat aber der Dateiname gleich geblieben ist.

Weiterer Anwendungsfall: Dateien auf dem Server bereinigen, weil z.B. sensible, personenbezogene
Daten gelöscht werden sollen inkl. aller generierten Thumbnails.

.. code-block:: php

	\nn\t3::Fal()->deleteProcessedImages( 'fileadmin/pfad/beispiel.jpg' );
	\nn\t3::Fal()->deleteProcessedImages( $sysFileReference );
	\nn\t3::Fal()->deleteProcessedImages( $sysFile );

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function deleteProcessedImages( $sysFile = '' )
   {
   	if (is_string($sysFile)) {
   		$sysFile = $this->getFalFile( $sysFile );
   	} else if (is_a($sysFile, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class, true)) {
   		$sysFile = $sysFile->getOriginalResource()->getOriginalFile();
   	}
   	if (!$sysFile) return;
   	if ($sysFileUid = $sysFile->getUid()) {
   		$rows = \nn\t3::Db()->findByValues('sys_file_processedfile', ['original'=>$sysFileUid]);
   		foreach ($rows as $row) {
   			\nn\t3::File()->unlink("{$row['storage']}:{$row['identifier']}");
   		}
   		\nn\t3::Db()->delete('sys_file_processedfile', ['original'=>$sysFileUid]);
   	}
   }
   

