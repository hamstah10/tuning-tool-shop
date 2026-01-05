
.. include:: ../../../../Includes.txt

.. _Db-deleteWithAllFiles:

==============================================
Db::deleteWithAllFiles()
==============================================

\\nn\\t3::Db()->deleteWithAllFiles(``$model``);
----------------------------------------------

The GDPR version of deletion.

Radical removal of all traces of a data set including the physical SysFiles,
linked to the model. To be used with caution, as no relations
are checked for the model to be deleted.

.. code-block:: php

	\nn\t3::deleteWithAllFiles( $model );

| ``@param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function deleteWithAllFiles( $model )
   {
   	$tableName = $this->getTableNameForModel( $model );
   	$uid = $model->getUid();
   	if (!$tableName || !$uid) return;
   	\nn\t3::Fal()->deleteForModel( $model );
   	\nn\t3::Db()->delete($tableName, $uid, true);
   }
   

