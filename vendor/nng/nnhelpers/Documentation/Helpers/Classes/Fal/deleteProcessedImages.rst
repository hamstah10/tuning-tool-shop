
.. include:: ../../../../Includes.txt

.. _Fal-deleteProcessedImages:

==============================================
Fal::deleteProcessedImages()
==============================================

\\nn\\t3::Fal()->deleteProcessedImages(``$sysFile = ''``);
----------------------------------------------

Deletes all physical thumbnail files that were generated for an image incl.
the data records in the ``sys_file_processedfile`` table.

The original image, which was passed as the ``$path`` argument, is not deleted.
The whole process forces the thumbnails for an image to be regenerated if, for example, the
source image has changed but the file name has remained the same.

Another use case: Cleaning up files on the server, e.g. because sensitive, personal data is to be
data including all generated thumbnails should be deleted.

.. code-block:: php

	\nn\t3::Fal()->deleteProcessedImages( 'fileadmin/path/example.jpg' );
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
   

