
.. include:: ../../../../Includes.txt

.. _TCA-getColumn:

==============================================
TCA::getColumn()
==============================================

\\nn\\t3::TCA()->getColumn(``$tableName = '', $fieldName = '', $useSchemaManager = false``);
----------------------------------------------

Gets configuration array for a field from the TCA.
Alias to ``\nn\t3::Db()->getColumn()``

.. code-block:: php

	\nn\t3::TCA()->getColumn( 'pages', 'media' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumn( $tableName = '', $fieldName = '', $useSchemaManager = false)
   {
   	return \nn\t3::Db()->getColumn( $tableName, $fieldName, $useSchemaManager );
   }
   

