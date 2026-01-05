
.. include:: ../../../../Includes.txt

.. _TCA-getColumns:

==============================================
TCA::getColumns()
==============================================

\\nn\\t3::TCA()->getColumns(``$tableName = '', $useSchemaManager = false``);
----------------------------------------------

Holt Konfigurations-Array für eine Tabelle aus dem TCA.
Alias zu ``\nn\t3::Db()->getColumns()``

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumns( $tableName = '', $useSchemaManager = false)
   {
   	return \nn\t3::Db()->getColumns( $tableName, $useSchemaManager );
   }
   

