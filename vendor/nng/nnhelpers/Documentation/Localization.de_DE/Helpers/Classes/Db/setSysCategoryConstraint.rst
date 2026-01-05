
.. include:: ../../../../Includes.txt

.. _Db-setSysCategoryConstraint:

==============================================
Db::setSysCategoryConstraint()
==============================================

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
----------------------------------------------

Constraint für sys_category / sys_category_record_mm zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse auf die angegebenen Sys-Categories-UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $querybuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@param boolean $useNotIn``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setSysCategoryConstraint ( &$queryBuilder = null, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false )
   {
   	if (!$sysCategoryUids) return $queryBuilder;
   	$and = [
   		$queryBuilder->expr()->eq('categoryMM.tablenames', $queryBuilder->expr()->literal($tableName)),
   		$queryBuilder->expr()->eq('categoryMM.fieldname', $queryBuilder->expr()->literal($categoryFieldName))
   	];
   	if (!$useNotIn) {
   		$and[] = $queryBuilder->expr()->in( 'categoryMM.uid_local', $sysCategoryUids );
   		$queryBuilder->andWhere(...$and);
   	} else {
   		$and[] = $queryBuilder->expr()->notIn('categoryMM.uid_local', $sysCategoryUids);
   		$queryBuilder->andWhere(
   			$queryBuilder->expr()->orX(
   				$queryBuilder->expr()->isNull('categoryMM.uid_foreign'),
   				$queryBuilder->expr()->andX(...$and)
   			)
   		);
   	}
   	$queryBuilder->leftJoin(
   		$tableName,
   		'sys_category_record_mm',
   		'categoryMM',
   		$queryBuilder->expr()->eq('categoryMM.uid_foreign', $tableName . '.uid')
   	)->groupBy('uid');
   	return $queryBuilder;
   }
   

