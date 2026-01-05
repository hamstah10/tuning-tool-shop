
.. include:: ../../../../Includes.txt

.. _Db-findOneByValues:

==============================================
Db::findOneByValues()
==============================================

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = []``);
----------------------------------------------

Finds ONE entry based on desired field values.

.. code-block:: php

	// SELECT FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' AND username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' OR username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true);
	
	// SELECT uid, name FROM fe_users WHERE firstname = 'david' OR username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true, false, ['uid', 'name']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@param array $fieldsToGet``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findOneByValues( $table = null, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = [] )
   {
   	$additionalQueryParams = [
   		'limit' => 1
   	];
   	$result = $this->findByValues( $table, $whereArr, $useLogicalOr, $ignoreEnableFields, $fieldsToGet, $additionalQueryParams );
   	return $result ? array_shift($result) : [];
   }
   

