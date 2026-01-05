
.. include:: ../../../../Includes.txt

.. _Db-fixFileReferencesForModel:

==============================================
Db::fixFileReferencesForModel()
==============================================

\\nn\\t3::Db()->fixFileReferencesForModel(``$model``);
----------------------------------------------

"Repairs" the SysFileReferences for models that have a property
that only ``reference``a ``FileReference``instead of an ``ObjectStorage`` 
instead of a FileReference. At the moment, it is unclear why TYPO3 has included these
persists them in the table ``sys_file_reference``, but empties the field ``tablenames``
field Ã¢ or does not set ``uid_foreign``. With an ``ObjectStorage
the problem does not occur.``

.. code-block:: php

	// must happen directly after persisting the model
	\nn\t3::Db()->fixFileReferencesForModel( $model );

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fixFileReferencesForModel( $model )
   {
   	$props = \nn\t3::Obj()->getProps( $model );
   	$modelTableName = \nn\t3::Obj()->getTableName( $model );
   	foreach ($props as $field=>$prop) {
   		if (is_a($prop, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class, true)) {
   			$sysFile = \nn\t3::Obj()->get($model, $field);
   			if (!$sysFile) continue;
   			$resource = $sysFile->getOriginalResource();
   			$uid = $resource->getUid();
   			if (!$uid) {
   				$result = $this->insert($sysFile);
   				$uid = $result->getUid();
   			}
   			if (!$resource) continue;
   			$uidForeign =  $resource->getProperty('uid_foreign');
   			$tableName = $resource->getProperty('tablenames');
   			if (!$uidForeign || !$tableName) {
   				$this->update('sys_file_reference', [
   					'uid_foreign'	=> $model->getUid(),
   					'tablenames'	=> $modelTableName,
   				], $uid);
   			}
   		}
   	}
   }
   

