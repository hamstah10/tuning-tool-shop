
.. include:: ../../../../Includes.txt

.. _TCA-getFalFields:

==============================================
TCA::getFalFields()
==============================================

\\nn\\t3::TCA()->getFalFields(``$tableName = ''``);
----------------------------------------------

Retrieves all field names from the TCA array that have a SysFileReference relation.
For the table ``tt_content`` this would be ``assets``, ``media`` etc.

.. code-block:: php

	\nn\t3::TCA()->getFalFields( 'pages' ); // => ['media', 'assets', 'image']

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFalFields( $tableName = '' )
   {
   	$fields = array_filter( \nn\t3::Db()->getColumns( $tableName ), function ( $item ) {
   		return ($item['config']['foreign_table'] ?? false) == 'sys_file_reference';
   	});
   	return array_keys( $fields );
   }
   

