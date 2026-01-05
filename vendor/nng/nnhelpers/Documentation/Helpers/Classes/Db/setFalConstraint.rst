
.. include:: ../../../../Includes.txt

.. _Db-setFalConstraint:

==============================================
Db::setFalConstraint()
==============================================

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
----------------------------------------------

Add constraint for sys_file_reference to a QueryBuilder.
Restricts the results to whether there is a FAL relation.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Only fetch datasets that have at least one SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... that do NOT have a SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... which have EXACTLY 2 SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... that have 2 or less (less than or equal) SysFileReferences
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
   

