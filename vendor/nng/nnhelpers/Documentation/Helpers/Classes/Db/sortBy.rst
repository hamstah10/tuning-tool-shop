
.. include:: ../../../../Includes.txt

.. _Db-sortBy:

==============================================
Db::sortBy()
==============================================

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
----------------------------------------------

Sorts the results of a query according to an array and a specific field.
Solves the problem that an ``->in()`` query does not return the results
in the order of the passed IDs. Example:
| ``$query->matching($query->in('uid', [3,1,2]));`` does not necessarily come
return in the order ``[3,1,2]``.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@param mixed $objectArray``
| ``@param string $fieldName``
| ``@param array $uidList``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function sortBy ( $objectArray, $fieldName = 'uid', $uidList = [] )
   {
   	if (method_exists( $objectArray, 'toArray')) {
   		$objectArray = $objectArray->toArray();
   	}
   	usort( $objectArray, function ($a, $b) use ( $uidList, $fieldName ) {
   		$p1 = array_search( \nn\t3::Obj()->accessSingleProperty($a, $fieldName), $uidList );
   		$p2 = array_search( \nn\t3::Obj()->accessSingleProperty($b, $fieldName), $uidList );
   		return $p1 > $p2 ? 1 : -1;
   	});
   	return $objectArray;
   }
   

