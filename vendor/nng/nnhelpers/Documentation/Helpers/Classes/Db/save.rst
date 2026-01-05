
.. include:: ../../../../Includes.txt

.. _Db-save:

==============================================
Db::save()
==============================================

\\nn\\t3::Db()->save(``$tableNameOrModel = '', $data = []``);
----------------------------------------------

Create database entry OR update an existing data record.

Decides independently whether the entry should be added to the database via ``UPDATE`` or ``INSERT`` 
or whether an existing data record needs to be updated. The data is
persisted directly!

Example for transferring a table name and an array:

.. code-block:: php

	// no uid transferred? Then INSERT a new data set
	\nn\t3::Db()->save('table', ['bodytext'=>'...']);
	
	// pass uid? Then UPDATE existing data
	\nn\t3::Db()->save('table', ['uid'=>123, 'bodytext'=>'...']);

Example for transferring a domain model:

.. code-block:: php

	// new model? Is inserted via $repo->add()
	$model = new \My\Nice\Model();
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );
	
	// existing model? Is updated via $repo->update()
	$model = $myRepo->findByUid(123);
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function save( $tableNameOrModel = '', $data = [] )
   {
   	if (\nn\t3::Obj()->isModel( $tableNameOrModel )) {
   		$uid = \nn\t3::Obj()->get( $tableNameOrModel, 'uid' ) ?: null;
   		$method = $uid ? 'update' : 'insert';
   	} else {
   		$uid = $data['uid'] ?? null;
   		$method = ($uid && $this->findByUid( $tableNameOrModel, $uid )) ? 'update' : 'insert';
   	}
   	return $this->$method( $tableNameOrModel, $data );
   }
   

