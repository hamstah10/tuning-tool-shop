
.. include:: ../../../../Includes.txt

.. _Fal-deleteSysFileReference:

==============================================
Fal::deleteSysFileReference()
==============================================

\\nn\\t3::Fal()->deleteSysFileReference(``$uidOrFileReference = NULL``);
----------------------------------------------

Löscht eine SysFileReference.
Siehe auch ``\nn\t3::Fal()->detach( $model, $field );`` zum Löschen aus einem Model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFileReference( 112 );
	\nn\t3::Fal()->deleteSysFileReference( \TYPO3\CMS\Extbase\Domain\Model\FileReference );

| ``@param $uidOrFileReference``

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function deleteSysFileReference( $uidOrFileReference = null )
   {
   	$uid = null;
   	if (is_a($uidOrFileReference, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class )) {
   		$uid = $uidOrFileReference->getUid();
   	} else if (is_numeric($uidOrFileReference)) {
   		$uid = $uidOrFileReference;
   	}
   	if ($uid) {
   		// ToDo: Ab Typo3 v10 prüfen, ob delete() implementiert wurde
   		/*
   		$resourceFactory = \nn\t3::injectClass( \TYPO3\CMS\Core\Resource\ResourceFactory::class );
   		$fileReferenceObject = $resourceFactory->getFileReferenceObject( $uid );
   		$fileReferenceObject->delete();
   		*/
   		// ToDo: Ab Typo3 v8 prüfen, ob das hier nicht einfacher wäre:
   		/*
   		$fal = $this->persistenceManager->getObjectByIdentifier($uid, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class, false);
   		$this->persistenceManager->remove( $fal );
   		*/
   		\nn\t3::Db()->delete('sys_file_reference', $uid);
   	}
   }
   

