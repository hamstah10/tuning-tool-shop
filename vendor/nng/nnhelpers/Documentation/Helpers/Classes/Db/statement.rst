
.. include:: ../../../../Includes.txt

.. _Db-statement:

==============================================
Db::statement()
==============================================

\\nn\\t3::Db()->statement(``$statement = '', $params = [], $types = []``);
----------------------------------------------

Send a "raw" query to the database.
Closer to the database is not possible. You are responsible for everything yourself.
Injections are only opposed by your (hopefully sufficient :) intelligence.

Helps, for example, with queries of tables that are not part of the Typo3 installation and
therefore could not be reached via the normal QueryBuilder.

.. code-block:: php

	// ALWAYS escape variables via!
	$keyword = \nn\t3::Db()->quote('search term');
	$rows = \nn\t3::Db()->statement( "SELECT FROM tt_news WHERE bodytext LIKE '%{$keyword}%'");
	
	// or better use prepared statements:
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%{$keyword}%"] );
	
	// Types can be passed (this is determined automatically for arrays)
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE uid IN (:uids)', ['uids'=>[1,2,3]], ['uids'=>Connection::PARAM_INT_ARRAY] );

With a ``SELECT`` statement, the rows from the database are returned as an array.
For all other statements (e.g. ``UPDATE`` or ``DELETE``), the number of affected rows is returned.

| ``@param string $statement``
| ``@param array $params``
| ``@param array $types``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function statement( $statement = '', $params = [], $types = [] )
   {
   	$connection = $this->getConnection();
   	// exec / fetchAll --> @siehe https://bit.ly/3ltPF0S
   	// set types automatically if params were used
   	foreach ($params as $key=>$val) {
   		// was type defined in arguments? then skip
   		if (isset($types[$key])) {
   			continue;
   		}
   		// type not defined - and not array? then add type
   		if (!is_array($val)) {
   			if (is_numeric($val)) {
   				$types[$key] = Connection::PARAM_INT;
   			} else {
   				$types[$key] = Connection::PARAM_STR;
   			}
   			continue;
   		}
   		// type not defined and array?
   		$allNumeric = count(array_filter($val, 'is_numeric')) === count($val);
   		$types[$key] = $allNumeric ? Connection::PARAM_INT_ARRAY : Connection::PARAM_STR_ARRAY;
   	}
   	if (stripos($statement, 'select ') !== false) {
   		$result = $connection->fetchAllAssociative( $statement, $params, $types );
   	} else {
   		$result = $connection->executeStatement( $statement, $params, $types );
   	}
   	return $result;
   }
   

