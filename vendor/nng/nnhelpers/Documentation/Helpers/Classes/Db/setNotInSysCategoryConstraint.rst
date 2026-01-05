
.. include:: ../../../../Includes.txt

.. _Db-setNotInSysCategoryConstraint:

==============================================
Db::setNotInSysCategoryConstraint()
==============================================

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
----------------------------------------------

Restrict constraint to records that are NOT in one of the specified categories.
Opposite and alias to ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setNotInSysCategoryConstraint( &$queryBuilder = null, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories' )
   {
   	return $this->setSysCategoryConstraint( $queryBuilder, $sysCategoryUids, $tableName, $categoryFieldName, true );
   }
   

