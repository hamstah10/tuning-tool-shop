
.. include:: ../../../../Includes.txt

.. _Db-insert:

==============================================
Db::insert()
==============================================

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
----------------------------------------------

Datenbank-Eintrag einfügen. Simpel und idiotensicher.
Entweder kann der Tabellenname und ein Array übergeben werden - oder ein Domain-Model.

Einfügen eines neuen Datensatzes per Tabellenname und Daten-Array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Einfügen eines neuen Models. Das Repository wird automatisch ermittelt.
Das Model wird direkt persistiert.

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
   

