
.. include:: ../../../../Includes.txt

.. _Fal-deleteForModel:

==============================================
Fal::deleteForModel()
==============================================

\\nn\\t3::Fal()->deleteForModel(``$model, $field = NULL``);
----------------------------------------------

Löscht die physischen Dateien für ein Model (oder ein einzelnes
Feld des Models) vom Server.

.. code-block:: php

	// ALLE Dateien des gesamten Models löschen
	\nn\t3::Fal()->deleteForModel( $model );
	
	// ALLE Dateien aus dem Feld "images" löschen
	\nn\t3::Fal()->deleteForModel( $model, 'images' );

| ``@param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model``
| ``@param string $field``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function deleteForModel ( $model, $field = null )
   {
   	$tableName = \nn\t3::Obj()->getTableName( $model );
   	$modelUid = $model->getUid();
   	if (!$tableName || !$modelUid) return;
   	$fileReferences = \nn\t3::Db()->findByValues('sys_file_reference', [
   		'tablenames' 	=> $tableName,
   		'uid_foreign'	=> $modelUid,
   	]);
   	$props = \nn\t3::Obj()->getProps( $model );
   	if ($fileReferences) {
   		try {
   			$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   			foreach ($fileReferences as $row) {
   				$fieldname = $row['fieldname'];
   				if ($field && $fieldname !== $field) {
   					continue;
   				}
   				if ($file = $resourceFactory->getFileObject( $row['uid_local'] )) {
   					\nn\t3::Fal()->clearCache( $file );
   					$file->delete();
   					\nn\t3::Obj()->set( $model, $fieldname, null );
   				}
   			}
   		} catch( \Exception $e ) {}
   	}
   }
   

