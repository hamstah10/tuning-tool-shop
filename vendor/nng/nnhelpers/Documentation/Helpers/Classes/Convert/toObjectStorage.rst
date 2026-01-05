
.. include:: ../../../../Includes.txt

.. _Convert-toObjectStorage:

==============================================
Convert::toObjectStorage()
==============================================

\\nn\\t3::Convert()->toObjectStorage(``$obj = NULL, $childType = NULL``);
----------------------------------------------

Converts something into an ObjectStorage

.. code-block:: php

	\nn\t3::Convert($something)->toObjectStorage()
	\nn\t3::Convert($something)->toObjectStorage( \My\Child\Type::class )
	
	\nn\t3::Convert()->toObjectStorage([['uid'=>1], ['uid'=>2], ...], \My\Child\Type::class )
	\nn\t3::Convert()->toObjectStorage([1, 2, ...], \My\Child\Type::class )

| ``@return ObjectStorage``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toObjectStorage( $obj = null, $childType = null ) {
   	$childType = $this->initialArgument !== null ? $obj : $childType;
   	$persistenceManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
   	$obj = $this->initialArgument !== null ? $this->initialArgument : $obj;
   	$objectStorage = GeneralUtility::makeInstance( ObjectStorage::class );
   	if ($childRepository = ($childType ? \nn\t3::Db()->getRepositoryForModel($childType) : false)) {
   		\nn\t3::Db()->ignoreEnableFields($childRepository);
   	}
   	if (is_a($obj, QueryResultInterface::class) || is_array($obj)) {
   		foreach($obj as $item) {
   			if (!$childType || is_a($item, $childType)) {
   				$objectStorage->attach( $item );
   			} else {
   				$uid = is_numeric($item) ? $item : \nn\t3::Obj()->get($item, 'uid');
   				if ($uid) {
   					if ($childType == \Nng\Nnhelpers\Domain\Model\FileReference::class) {
   						$childType = \TYPO3\CMS\Extbase\Domain\Model\FileReference::class;
   					}
   					// @returns \TYPO3\CMS\Extbase\Domain\Model\FileReference
   					$child = $persistenceManager->getObjectByIdentifier($uid, $childType, false);
   					$objectStorage->attach( $child );
   				} else {
   					$child = GeneralUtility::makeInstance( $childType );
   					$objectStorage->attach( $child );
   				}
   			}
   		}
   	}
   	return $objectStorage;
   }
   

