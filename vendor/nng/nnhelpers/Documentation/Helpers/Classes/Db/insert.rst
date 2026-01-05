
.. include:: ../../../../Includes.txt

.. _Db-insert:

==============================================
Db::insert()
==============================================

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
----------------------------------------------

Insert database entry. Simple and foolproof.
Either the table name and an array can be transferred - or a domain model.

Inserting a new data set via table name and data array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Insert a new model. The repository is determined automatically.
The model is persisted directly.

.. code-block:: php

	$model = new \My\Nice\Model();
	$persistedModel = \nn\t3::Db()->insert( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insert ( $tableNameOrModel = '', $data = [] )
   {
   	if (\nn\t3::Obj()->isModel( $tableNameOrModel )) {
   		$persistenceManager = \nn\t3::injectClass( PersistenceManager::class );
   		$persistenceManager->add( $tableNameOrModel );
   		$persistenceManager->persistAll();
   		$this->fixFileReferencesForModel( $tableNameOrModel );
   		return $tableNameOrModel;
   	}
   	$data = $this->filterDataForTable( $data, $tableNameOrModel );
   	$queryBuilder = $this->getQueryBuilder( $tableNameOrModel );
   	$queryBuilder->insert( $tableNameOrModel )
   		->values($data)->executeStatement();
   	$data['uid'] = $queryBuilder->getConnection()->lastInsertId();
   	return $data;
   }
   

