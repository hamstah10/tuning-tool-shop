
.. include:: ../../../../Includes.txt

.. _Db-get:

==============================================
Db::get()
==============================================

\\nn\\t3::Db()->get(``$uid, $modelType = '', $ignoreEnableFields = false``);
----------------------------------------------

Get one or more domain models/entities using a ``uid``
A single ``$uid`` or a list of ``$uids`` can be passed.

Returns the "real" model/object including all relations,
analogous to a query via the repository.

.. code-block:: php

	// Get a single model by its uid
	$model = \nn\t3::Db()->get( 1, \Nng\MyExt\Domain\Model\Name::class );
	
	// Get an array of models based on their uids
	$modelArray = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Model\Name::class );
	
	// Also returns hidden models
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
   

