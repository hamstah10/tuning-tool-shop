
.. include:: ../../../../Includes.txt

.. _Db-getQueryBuilder:

==============================================
Db::getQueryBuilder()
==============================================

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
----------------------------------------------

QueryBuilder für eine Tabelle holen

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Beispiel:

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
   

