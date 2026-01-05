
.. include:: ../../../../Includes.txt

.. _TCA-getFalFields:

==============================================
TCA::getFalFields()
==============================================

\\nn\\t3::TCA()->getFalFields(``$tableName = ''``);
----------------------------------------------

Holt alle Feldnamen aus dem TCA-Array, die eine SysFileReference-Relation haben.
Bei der Tabelle ``tt_content`` wären das z.B. ``assets``, ``media`` etc.

.. code-block:: php

	\nn\t3::TCA()->getFalFields( 'pages' );    // => ['media', 'assets', 'image']

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
   

