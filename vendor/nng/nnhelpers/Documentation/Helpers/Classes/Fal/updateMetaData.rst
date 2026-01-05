
.. include:: ../../../../Includes.txt

.. _Fal-updateMetaData:

==============================================
Fal::updateMetaData()
==============================================

\\nn\\t3::Fal()->updateMetaData(``$filenameOrSysFile = '', $data = []``);
----------------------------------------------

Update the information in ``sys_file_metadata`` and ``sys_file``

.. code-block:: php

	\nn\t3::Fal()->updateMetaData( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->updateMetaData( $fileReference );
	\nn\t3::Fal()->updateMetaData( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file
| ``@param $data`` Array with data to be updated.
If empty, image data is read automatically
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
   

