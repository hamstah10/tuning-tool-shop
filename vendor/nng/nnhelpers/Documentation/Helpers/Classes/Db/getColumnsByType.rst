
.. include:: ../../../../Includes.txt

.. _Db-getColumnsByType:

==============================================
Db::getColumnsByType()
==============================================

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
----------------------------------------------

Get fields of a table by a specific type

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@param string $table``
| ``@param string $colType``
| ``@param boolean $useSchemaManager``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumnsByType( $table = '', $colType = '', $useSchemaManager = false )
   {
   	$cols = $this->getColumns( $table, $useSchemaManager );
   	$results = [];
   	foreach ($cols as $fieldName=>$col) {
   		$type = $col['config']['type'] ?? false;
   		$fieldName = GeneralUtility::camelCaseToLowerCaseUnderscored( $fieldName );
   		if ($type == $colType) {
   			$results[$fieldName] = array_merge(['fieldName'=>$fieldName], $col);
   		}
   	}
   	return $results;
   }
   

