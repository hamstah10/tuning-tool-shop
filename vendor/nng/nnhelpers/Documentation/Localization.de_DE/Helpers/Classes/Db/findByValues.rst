
.. include:: ../../../../Includes.txt

.. _Db-findByValues:

==============================================
Db::findByValues()
==============================================

\\nn\\t3::Db()->findByValues(``$table = NULL, $where = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = [], $additionalQueryParams = []``);
----------------------------------------------

Findet ALLE Einträge anhand eines gewünschten Feld-Wertes.
Funktioniert auch, wenn Frontend noch nicht initialisiert wurde.

.. code-block:: php

	// SELECT  FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT  FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findByValues('fe_users', ['uid'=>[1,2,3]]);
	
	// SELECT uid, username FROM fe_users WHERE name = 'test'
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, ['uid', 'username']);
	
	// SELECT  FROM fe_users WHERE name = 'test' LIMIT 1
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, false, ['limit'=>1]);
	
	// SELECT  FROM fe_users WHERE name = 'test' LIMIT 2 OFFSET 3
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, false, ['limit'=>2, 'offset'=>3]);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@param array|boolean $fieldsToGet``
| ``@param array $additionalQueryParams``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findByValues( $table = null, $where = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = [], $additionalQueryParams = [] )
   {
   	// Nur Felder behalten, die auch in Tabelle (TCA) existieren
   	$whereArr = $this->filterDataForTable( $where, $table );
   	// nichts mehr übrig? Dann macht die Abfrage keinen Sinn
   	if ($where && !$whereArr) {
   		return [];
   	}
   	if (!$fieldsToGet) {
   		$fieldsToGet = ['*'];
   	}
   	$queryBuilder = $this->getQueryBuilder( $table );
   	$queryBuilder->select(...$fieldsToGet)->from( $table );
   	// Alle Einschränkungen z.B. hidden oder starttime / endtime entfernen?
   	if ($ignoreEnableFields) {
   		$queryBuilder->getRestrictions()->removeAll();
   	}
   	// set LIMIT?
   	if ($limit = $additionalQueryParams['limit'] ?? false) {
   		$queryBuilder->setMaxResults( $limit );
   	}
   	// set LIMIT OFFSET?
   	if ($offset = $additionalQueryParams['offset'] ?? false) {
   		$queryBuilder->setFirstResult( $offset );
   	}
   	if ($whereArr) {
   		foreach ($whereArr as $colName=>$v) {
   			if (is_array($v)) {
   				$v = $this->quote( $v );
   				$expr = $queryBuilder->expr()->in($colName, $v );
   				if ($uids = \nn\t3::Arrays($v)->intExplode()) {
   					$this->orderBy( $queryBuilder, ["{$table}.{$colName}"=>$uids] );
   				}
   			} else {
   				$expr = $queryBuilder->expr()->eq( $colName, $queryBuilder->createNamedParameter( $v ) );
   			}
   			if (!$useLogicalOr) {
   				$queryBuilder->andWhere( $expr );
   			} else {
   				$queryBuilder->orWhere( $expr );
   			}
   		}
   	}
   	// "deleted" IMMER berücksichtigen!
   	if ($deleteCol = $this->getDeleteColumn( $table )) {
   		$queryBuilder->andWhere( $queryBuilder->expr()->eq($deleteCol, 0) );
   	}
   	$rows = $queryBuilder->executeQuery()->fetchAllAssociative();
   	return $rows;
   }
   

