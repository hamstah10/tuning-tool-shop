
.. include:: ../../../../Includes.txt

.. _Db-setFalConstraint:

==============================================
Db::setFalConstraint()
==============================================

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
----------------------------------------------

Constraint für sys_file_reference zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse darauf, ob es eine FAL-Relation gibt.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Nur Datensätze holen, die für falfield mindestes eine SysFileReference haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... die KEINE SysFileReference für falfield haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... die GENAU 2 SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... die 2 oder weniger (less than or equal) SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param string $tableName``
| ``@param string $falFieldName``
| ``@param boolean $numFal``
| ``@param boolean $operator``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setFalConstraint( &$queryBuilder = null, $tableName = '', $falFieldName = '', $numFal = true, $operator = false )
   {
   	if ($operator === false) {
   		if ($numFal === 0 || $numFal === 1) {
   			$operator = 'eq';
   		}
   		if ($numFal === true) 	{
   			$numFal = 1;
   			$operator = 'gte';
   		}
   		if ($numFal === false) 	{
   			$numFal = 0;
   		}
   	}
   	if ($operator === false) {
   		$operator = 'eq';
   	}
   	$groupName = 'cnt_' . preg_replace('[^a-zA-Z0-1]', '', $falFieldName);
   	$subQuery = $this->getQueryBuilder( 'sys_file_reference' )
   		->selectLiteral('COUNT(s.uid)')
   		->from('sys_file_reference', 's')
   		->andWhere($queryBuilder->expr()->eq('s.fieldname', $queryBuilder->createNamedParameter($falFieldName)))
   		->andWhere($queryBuilder->expr()->eq('s.uid_foreign', $queryBuilder->quoteIdentifier($tableName.'.uid')))
   		->getSql();
   	$queryBuilder
   		->addSelectLiteral("({$subQuery}) AS {$groupName}")
   		->having( $queryBuilder->expr()->{$operator}($groupName, $numFal) );
   	return $queryBuilder;
   }
   

