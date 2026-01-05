
.. include:: ../../../../Includes.txt

.. _Db-deleteWithAllFiles:

==============================================
Db::deleteWithAllFiles()
==============================================

\\nn\\t3::Db()->deleteWithAllFiles(``$model``);
----------------------------------------------

Die DSGVO-Variante des Löschens.

Radikales entfernen aller Spuren eines Datensatzen inkl. der physischen SysFiles,
die mit dem Model verknüpft sind. Mit Vorsicht zu verwenden, da keine Relationen
auf das zu löschende Model geprüft werden.

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
   

