
.. include:: ../../../../Includes.txt

.. _Fal-updateMetaData:

==============================================
Fal::updateMetaData()
==============================================

\\nn\\t3::Fal()->updateMetaData(``$filenameOrSysFile = '', $data = []``);
----------------------------------------------

Update der Angaben in ``sys_file_metadata`` und ``sys_file``

.. code-block:: php

	\nn\t3::Fal()->updateMetaData( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->updateMetaData( $fileReference );
	\nn\t3::Fal()->updateMetaData( $falFile );

| ``@param $filenameOrSysFile``     FAL oder Pfad (String) zu der Datei
| ``@param $data``              Array mit Daten, die geupdated werden sollen.
Falls leer, werden Bilddaten automatisch gelesen
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function updateMetaData ( $filenameOrSysFile = '', $data = [] )
   {
   	if (is_string($filenameOrSysFile)) {
   		if ($falFile = $this->getFalFile( $filenameOrSysFile )) {
   			$filenameOrSysFile = $falFile;
   		}
   	}
   	if (!$data) {
   		$data = \nn\t3::File()->getData( $filenameOrSysFile );
   	}
   	$storage = \nn\t3::File()->getStorage( $filenameOrSysFile );
   	$publicUrl = \nn\t3::File()->getPublicUrl( $filenameOrSysFile );
   	$destinationFile = GeneralUtility::makeInstance( ResourceFactory::class )->retrieveFileOrFolderObject($publicUrl);
   	$indexer = GeneralUtility::makeInstance(Indexer::class, $storage);
   	$indexer->updateIndexEntry($destinationFile);
   }
   

