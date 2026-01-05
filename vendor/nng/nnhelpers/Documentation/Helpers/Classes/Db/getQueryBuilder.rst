
.. include:: ../../../../Includes.txt

.. _Db-getQueryBuilder:

==============================================
Db::getQueryBuilder()
==============================================

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
----------------------------------------------

Get QueryBuilder for a table

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Example:

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	$queryBuilder->select('name')->from( 'fe_users' );
	$queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	$rows = $queryBuilder->executeStatement()->fetchAllAssociative();

| ``@param string $table``
| ``@return QueryBuilder``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getQueryBuilder( $table = '' )
   {
   	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable( $table );
   	return $queryBuilder;
   }
   

