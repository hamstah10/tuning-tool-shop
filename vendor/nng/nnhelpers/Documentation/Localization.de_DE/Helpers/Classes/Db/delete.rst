
.. include:: ../../../../Includes.txt

.. _Db-delete:

==============================================
Db::delete()
==============================================

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
----------------------------------------------

Datenbank-Eintrag löschen. Klein und Fein.
Es kann entweder ein Tabellenname und die UID übergeben werden - oder ein Model.

Löschen eines Datensatzes per Tabellenname und uid oder einem beliebigen Constraint:

.. code-block:: php

	// Löschen anhand der uid
	\nn\t3::Db()->delete('table', $uid);
	
	// Löschen anhand eines eigenen Feldes
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	
	// Eintrag komplett und unwiderruflich löschen (nicht nur per Flag deleted = 1 entfernen)
	\nn\t3::Db()->delete('table', $uid, true);
	

Löschen eines Datensatzes per Model:

.. code-block:: php

	\nn\t3::Db()->delete( $model );

| ``@param mixed $table``
| ``@param array $constraint``
| ``@param boolean $reallyDelete``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function delete ( $table = '', $constraint = [], $reallyDelete = false )
   {
   	if (\nn\t3::Obj()->isModel($table)) {
   		$model = $table;
   		$repository = $this->getRepositoryForModel( $model );
   		$repository->remove( $model );
   		$this->persistAll();
   		return $model;
   	}
   	if (!$constraint) return false;
   	if (is_numeric($constraint)) {
   		$constraint = ['uid' => $constraint];
   	}
   	$deleteColumn = $reallyDelete ? false : $this->getDeleteColumn( $table );
   	if ($deleteColumn) {
   		return $this->update( $table, [$deleteColumn => 1], $constraint );
   	}
   	$queryBuilder = $this->getQueryBuilder( $table );
   	$queryBuilder->delete($table);
   	foreach ($constraint as $k=>$v) {
   		if (is_array($v)) {
   			$queryBuilder->andWhere(
   				$queryBuilder->expr()->in( $k, $queryBuilder->createNamedParameter($v, Connection::PARAM_STR_ARRAY) )
   			);
   		} else {
   			$queryBuilder->andWhere(
   				$queryBuilder->expr()->eq( $k, $queryBuilder->createNamedParameter($v))
   			);
   		}
   	}
   	return $queryBuilder->executeStatement();
   }
   

