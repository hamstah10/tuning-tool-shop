
.. include:: ../../../../Includes.txt

.. _Db-insertMultiple:

==============================================
Db::insertMultiple()
==============================================

\\nn\\t3::Db()->insertMultiple(``$tableName = '', $rows = [], $colOrder = []``);
----------------------------------------------

Mehrere Zeilen in Datenbank einfügen.

.. code-block:: php

	use TYPO3\CMS\Core\Database\Connection;
	
	$data = [
	    ['title' => 'Eins', 'tstamp'=>123],
	    ['title' => 'Zwei', 'tstamp'=>123],
	];
	$colOrder = [
	    'tstamp' => Connection::PARAM_INT,
	    'title' => Connection::PARAM_STR,
	];
	
	\nn\t3::Db()->insertMultiple('table', $data, $colOrder);

| ``@param string $tableName``
| ``@param array $rows``
| ``@param array $colOrder``
| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertMultiple ( $tableName = '', $rows = [], $colOrder = [] )
   {
   	$connection = $connection = $this->getConnection();
   	if (!$rows) {
   		return true;
   	}
   	$flattened = [];
   	foreach ($rows as $row) {
   		$insert = [];
   		foreach ($colOrder as $col=>$type) {
   			$insert[] = $row[$col] ?? '';
   		}
   		$flattened[] = $insert;
   	}
   	$result = $connection->bulkInsert(
   		$tableName,
   		$flattened,
   		array_keys( $colOrder ),
   		array_values( $colOrder ),
   	);
   	return $result;
   }
   

