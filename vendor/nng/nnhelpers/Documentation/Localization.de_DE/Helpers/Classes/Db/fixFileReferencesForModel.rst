
.. include:: ../../../../Includes.txt

.. _Db-fixFileReferencesForModel:

==============================================
Db::fixFileReferencesForModel()
==============================================

\\nn\\t3::Db()->fixFileReferencesForModel(``$model``);
----------------------------------------------

"Repariert" die SysFileReferences für Modelle, die eine Property haben,
die statt einer ``ObjectStorage<FileReference>`` nur eine ``FileReference``
referenzieren. Zum aktuellen Zeitpunkt ist es unklar, weshalb TYPO3 diese zwar
in der Tabelle ``sys_file_reference`` persistiert, aber das Feld ``tablenames``
leert – bzw. ``uid_foreign`` nicht setzt. Bei einer ``ObjectStorage<FileReference>``
tritt das Problem nicht auf.

.. code-block:: php

	// muss direkt nach dem persistieren des Models passieren
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
   

