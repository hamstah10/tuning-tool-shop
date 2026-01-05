
.. include:: ../../../../Includes.txt

.. _Fal-deleteSysFile:

==============================================
Fal::deleteSysFile()
==============================================

\\nn\\t3::Fal()->deleteSysFile(``$uidOrObject = NULL``);
----------------------------------------------

Löscht ein SysFile (Datensatz aus Tabelle ``sys_file``) und alle dazugehörigen SysFileReferences.
Eine radikale Art, um ein Bild komplett aus der Indizierung von Typo3 zu nehmen.

Die physische Datei wird nicht vom Server gelöscht!
Siehe ``\nn\t3::File()->unlink()`` zum Löschen der physischen Datei.
Siehe ``\nn\t3::Fal()->detach( $model, $field );`` zum Löschen aus einem Model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFile( 1201 );
	\nn\t3::Fal()->deleteSysFile( 'fileadmin/pfad/zum/bild.jpg' );
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
   

