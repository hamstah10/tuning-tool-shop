
.. include:: ../../../../Includes.txt

.. _Db-update:

==============================================
Db::update()
==============================================

\\nn\\t3::Db()->update(``$tableNameOrModel = '', $data = [], $uid = NULL``);
----------------------------------------------

Update database entry. Quick and easy.
The update can be done either by table name and data array.
Or you can pass a model.

Examples:

.. code-block:: php

	// UPDATES table SET title='new' WHERE uid=1
	\nn\t3::Db()->update('table', ['title'=>'new'], 1);
	
	// UPDATES table SET title='new' WHERE uid IN (1,2,3)
	\nn\t3::Db()->update('table', ['title'=>'new'], ['uid'=>[1,2,3]);
	
	// UPDATE table SET title='new' WHERE email='david@99grad.de' AND pid=12
	\nn\t3::Db()->update('table', ['title'=>'new'], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

With ``true`` instead of a ``$uid`` ALL records of the table are updated.

.. code-block:: php

	// UPDATE table SET test='1' WHERE 1
	\nn\t3::Db()->update('table', ['test'=>1], true);

Instead of a table name, a simple model can also be passed.
The repository is determined automatically and the model is persisted directly.

.. code-block:: php

	$model = $myRepo->findByUid(1);
	\nn\t3::Db()->update( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@param int $uid``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function update ( $tableNameOrModel = '', $data = [], $uid = null )
   {
   	if (\nn\t3::Obj()->isModel( $tableNameOrModel )) {
   		$persistenceManager = \nn\t3::injectClass( PersistenceManager::class );
   		$persistenceManager->update( $tableNameOrModel );
   		$persistenceManager->persistAll();
   		$this->fixFileReferencesForModel( $tableNameOrModel );
   		return $tableNameOrModel;
   	}
   	$queryBuilder = $this->getQueryBuilder( $tableNameOrModel );
   	$queryBuilder->getRestrictions()->removeAll();
   	$queryBuilder->update( $tableNameOrModel );
   	$data = $this->filterDataForTable( $data, $tableNameOrModel );
   	if (!$data) return false;
   	foreach ($data as $k=>$v) {
   		$queryBuilder->set( $k, $v );
   	}
   	if ($uid === null) {
   		$uid = $data['uid'] ?? null;
   	}
   	if ($uid !== true) {
   		if (is_numeric($uid)) {
   			$uid = ['uid' => $uid];
   		}
   		foreach ($uid as $k=>$v) {
   			if (is_array($v)) {
   				$v = $this->quote( $v );
   				$queryBuilder->andWhere(
   					$queryBuilder->expr()->in( $k, $queryBuilder->createNamedParameter($v, Connection::PARAM_STR_ARRAY) )
   				);
   			} else {
   				$queryBuilder->andWhere(
   					$queryBuilder->expr()->eq( $k, $queryBuilder->createNamedParameter($v) )
   				);
   			}
   		}
   	}
   	return $queryBuilder->executeStatement();
   }
   

