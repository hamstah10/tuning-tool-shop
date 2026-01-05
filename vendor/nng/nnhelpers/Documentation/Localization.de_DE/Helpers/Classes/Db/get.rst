
.. include:: ../../../../Includes.txt

.. _Db-get:

==============================================
Db::get()
==============================================

\\nn\\t3::Db()->get(``$uid, $modelType = '', $ignoreEnableFields = false``);
----------------------------------------------

Ein oder mehrere Domain-Model/Entity anhand einer ``uid`` holen.
Es kann eine einzelne ``$uid`` oder eine Liste von ``$uids`` übergeben werden.

Liefert das "echte" Model/Object inklusive aller Relationen,
analog zu einer Query über das Repository.

.. code-block:: php

	// Ein einzelnes Model anhand seiner uid holen
	$model = \nn\t3::Db()->get( 1, \Nng\MyExt\Domain\Model\Name::class );
	
	// Ein Array an Models anhand ihrer uids holen
	$modelArray = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class );
	
	// Gibt auch hidden Models zurück
	$modelArrayWithHidden = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class, true );

| ``@param int $uid``
| ``@param string $modelType``
| ``@param boolean $ignoreEnableFields``
| ``@return Object``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $uid, $modelType = '', $ignoreEnableFields = false)
   {
   	if (!is_array($uid)) {
   		$persistenceManager = \nn\t3::injectClass( PersistenceManager::class );
   		$entity = $persistenceManager->getObjectByIdentifier($uid, $modelType, false);
   		return $entity;
   	}
   	$dataMapper = \nn\t3::injectClass(DataMapper::class);
   	$tableName = $this->getTableNameForModel( $modelType);
   	$rows = $this->findByUids( $tableName, $uid, $ignoreEnableFields );
   	return $dataMapper->map( $modelType, $rows);
   }
   

