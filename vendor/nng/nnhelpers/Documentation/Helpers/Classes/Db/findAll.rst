
.. include:: ../../../../Includes.txt

.. _Db-findAll:

==============================================
Db::findAll()
==============================================

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
----------------------------------------------

Retrieves ALL entries from a database table.

The data is returned as an array - this is (unfortunately) still the absolute
most performant way to fetch many data records from a table, since no ``DataMapper``
has to parse the individual rows.

.. code-block:: php

	// Get all data records. "hidden" is taken into account.
	\nn\t3::Db()->findAll('fe_users');
	
	// Also fetch data records that are "hidden"
	\nn\t3::Db()->findAll('fe_users', true);

| ``@param string $table``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findAll( $table = '', $ignoreEnableFields = false )
   {
   	$rows = $this->findByValues( $table, [], false, $ignoreEnableFields );
   	return $rows ?: [];
   }
   

