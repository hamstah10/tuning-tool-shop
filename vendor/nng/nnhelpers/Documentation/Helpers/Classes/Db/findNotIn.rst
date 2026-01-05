
.. include:: ../../../../Includes.txt

.. _Db-findNotIn:

==============================================
Db::findNotIn()
==============================================

\\nn\\t3::Db()->findNotIn(``$table = '', $colName = '', $values = [], $ignoreEnableFields = false``);
----------------------------------------------

Reversal of ``\nn\t3::Db()->findIn()``:

Finds ALL entries that do NOT contain a value from the ``$values`` array in the ``$column`` column.
Also works if the frontend has not yet been initialized.

.. code-block:: php

	// SELECT FROM fe_users WHERE uid NOT IN (1,2,3)
	\nn\t3::Db()->findNotIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username NOT IN ('david', 'martin')
	\nn\t3::Db()->findNotIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $colName``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findNotIn( $table = '', $colName = '', $values = [], $ignoreEnableFields = false )
   {
   	$queryBuilder = $this->getQueryBuilder( $table );
   	$queryBuilder->select('*')->from( $table );
   	// Alle Einschränkungen z.B. hidden oder starttime / endtime entfernen?
   	if ($ignoreEnableFields) {
   		$queryBuilder->getRestrictions()->removeAll();
   	}
   	// "deleted" IMMER berücksichtigen!
   	if ($deleteCol = $this->getDeleteColumn( $table )) {
   		$queryBuilder->andWhere( $queryBuilder->expr()->eq($deleteCol, 0) );
   	}
   	$values = $this->quote( $values );
   	$expr = $queryBuilder->expr()->notIn( $colName, $values );
   	$queryBuilder->andWhere( $expr );
   	$rows = $queryBuilder->executeQuery()->fetchAllAssociative();
   	return $rows;
   }
   

