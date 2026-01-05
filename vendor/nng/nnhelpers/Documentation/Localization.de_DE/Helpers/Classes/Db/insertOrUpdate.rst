
.. include:: ../../../../Includes.txt

.. _Db-insertOrUpdate:

==============================================
Db::insertOrUpdate()
==============================================

\\nn\\t3::Db()->insertOrUpdate(``$tableName, $whereArr = [], $model = []``);
----------------------------------------------

Store an item in the database, but keep it unique by $whereArr = []

.. code-block:: php

	$data = [ profileUid: "", entityType: "", entityUid: "",  ... ];
	\nn\un::Interaction()->insertOrUpdate( $data );

| ``@param int $feUserId``
| ``@param array $data``
| ``@return array $model``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertOrUpdate($tableName, $whereArr = [], $model = [])
   {
   	// check if entityUid exists
   	$exists = $this->findOneByValues($tableName, $whereArr);
   	if ($exists) {
   		// remove existing entry
   		$this->delete($tableName, $whereArr, true);
   	}
   	return $this->insert($model);
   }
   

