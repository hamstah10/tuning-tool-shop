
.. include:: ../../../../Includes.txt

.. _Db-delete:

==============================================
Db::delete()
==============================================

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
----------------------------------------------

Delete database entry. Small and fine.
Either a table name and the UID can be transferred - or a model.

Delete a data record by table name and uid or any constraint:

.. code-block:: php

	// Deletion based on the uid
	\nn\t3::Db()->delete('table', $uid);
	
	// Delete using a custom field
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	
	// Delete entry completely and irrevocably (do not just remove via flag deleted = 1)
	\nn\t3::Db()->delete('table', $uid, true);
	

Delete a data record per model:

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
   

