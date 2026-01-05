
.. include:: ../../../../Includes.txt

.. _Fal-deleteSysFile:

==============================================
Fal::deleteSysFile()
==============================================

\\nn\\t3::Fal()->deleteSysFile(``$uidOrObject = NULL``);
----------------------------------------------

Deletes a SysFile (data record from table ``sys_file``) and all associated SysFileReferences.
A radical way to completely remove an image from the Typo3 indexing.

The physical file is not deleted from the server!
See ``\nn\t3::File()->unlink()`` to delete the physical file.
See ``\nn\t3::Fal()->detach( $model, $field );`` to delete from a model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFile( 1201 );
	\nn\t3::Fal()->deleteSysFile( 'fileadmin/path/to/image.jpg' );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\File );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\FileReference );

| ``@param $uidOrObject``

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function deleteSysFile( $uidOrObject = null )
   {
   	$resourceFactory = \nn\t3::injectClass( \TYPO3\CMS\Core\Resource\ResourceFactory::class );
   	if (!$uidOrObject) return false;
   	if (is_string($uidOrObject) && !is_numeric($uidOrObject)) {
   		// Pfad wurde übergeben
   		$uidOrObject = \nn\t3::File()->relPath( $uidOrObject );
   		$storage = \nn\t3::File()->getStorage($uidOrObject, false);
   		if (!$storage) return false;
   		$basePath = $storage->getConfiguration()['basePath'];
   		$filepathInStorage = substr( $uidOrObject, strlen($basePath) );
   		$identifier = '/'.ltrim($filepathInStorage, '/');
   		$entry = \nn\t3::Db()->findOneByValues('sys_file', [
   			'storage' => $storage->getUid(),
   			'identifier' => $identifier,
   		]);
   		if ($entry) {
   			$uid = $entry['uid'];
   			$uidOrObject = $uid;
   		}
   	}
   	if (is_a($uidOrObject, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class )) {
   		/* \TYPO3\CMS\Core\Resource\FileReference */
   		$uid = $uidOrObject->getUid();
   		$fileReferenceObject = $resourceFactory->getFileReferenceObject( $uid );
   		$fileReferenceObject->getOriginalFile()->delete();
   	} else if (is_a($uidOrObject, \TYPO3\CMS\Core\Resource\File::class )) {
   		/* \TYPO3\CMS\Core\Resource\File */
   		$uid = $uidOrObject->getUid();
   		$uidOrObject->delete();
   	} else if (is_numeric($uidOrObject)) {
   		// uid wurde übergeben
   		$uid = $uidOrObject;
   		\nn\t3::Db()->delete('sys_file', $uidOrObject);
   	}
   	if ($uid) {
   		// Zugehörge Datensätze aus `sys_file_references` löschen
   		\nn\t3::Db()->delete('sys_file_reference', ['uid_local' => $uid], true);
   	}
   	return $uid;
   }
   

