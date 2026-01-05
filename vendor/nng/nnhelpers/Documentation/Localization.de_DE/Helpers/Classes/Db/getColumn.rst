
.. include:: ../../../../Includes.txt

.. _Db-getColumn:

==============================================
Db::getColumn()
==============================================

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
----------------------------------------------

Eine Tabellen-Spalte (TCA) für bestimmte Tabelle holen

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
   

