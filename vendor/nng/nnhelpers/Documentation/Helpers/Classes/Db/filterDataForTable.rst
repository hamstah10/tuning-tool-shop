
.. include:: ../../../../Includes.txt

.. _Db-filterDataForTable:

==============================================
Db::filterDataForTable()
==============================================

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
----------------------------------------------

Only keep elements in key/val array whose keys also
exist in TCA for certain table

| ``@param array $data``
| ``@param string $table``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function filterDataForTable ( $data = [], $table = '' )
   {
   	$tcaColumns = $this->getColumns( $table );
   	$existingCols = array_intersect( array_keys($data), array_keys($tcaColumns));
   	foreach ($data as $k=>$v) {
   		if (!in_array($k, $existingCols)) {
   			unset($data[$k]);
   		}
   	}
   	return $data;
   }
   

