
.. include:: ../../../../Includes.txt

.. _Db-getColumn:

==============================================
Db::getColumn()
==============================================

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
----------------------------------------------

Get a table column (TCA) for a specific table

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@param string $table``
| ``@param string $colName``
| ``@param boolean $useSchemaManager``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumn ( $table = '', $colName = '', $useSchemaManager = false )
   {
   	$cols = $this->getColumns( $table, $useSchemaManager );
   	return $cols[$colName] ?? [];
   }
   

