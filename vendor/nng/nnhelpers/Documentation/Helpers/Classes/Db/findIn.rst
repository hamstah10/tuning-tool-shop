
.. include:: ../../../../Includes.txt

.. _Db-findIn:

==============================================
Db::findIn()
==============================================

\\nn\\t3::Db()->findIn(``$table = '', $column = '', $values = [], $ignoreEnableFields = false``);
----------------------------------------------

Finds ALL entries that contain a value from the ``$values`` array in the ``$column`` column.
Also works if the frontend has not yet been initialized.
Alias to ``\nn\t3::Db()->findByValues()``

.. code-block:: php

	// SELECT FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username IN ('david', 'martin')
	\nn\t3::Db()->findIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $column``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findIn( $table = '', $column = '', $values = [], $ignoreEnableFields = false )
   {
   	if (!$values) return [];
   	return $this->findByValues( $table, [$column=>$values], false, $ignoreEnableFields );
   }
   

