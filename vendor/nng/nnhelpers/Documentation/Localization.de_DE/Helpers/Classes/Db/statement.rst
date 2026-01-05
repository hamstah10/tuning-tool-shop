
.. include:: ../../../../Includes.txt

.. _Db-statement:

==============================================
Db::statement()
==============================================

\\nn\\t3::Db()->statement(``$statement = '', $params = [], $types = []``);
----------------------------------------------

Eine "rohe" Query an die Datenbank absetzen.
Näher an der Datenbank geht nicht. Du bist für alles selbst verantwortlich.
Injections steht nur Deine (hoffentlich ausreichende :) Intelligenz entgegen.

Hilft z.B. bei Abfragen von Tabellen, die nicht Teil der Typo3 Installation sind und
daher über den normal QueryBuilder nicht erreicht werden könnten.

.. code-block:: php

	// Variablen IMMER über escapen!
	$keyword = \nn\t3::Db()->quote('suchbegriff');
	$rows = \nn\t3::Db()->statement( "SELECT  FROM tt_news WHERE bodytext LIKE '%{$keyword}%'");
	
	// oder besser gleich prepared statements verwenden:
	$rows = \nn\t3::Db()->statement( 'SELECT  FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%{$keyword}%"] );
	
	// Typen können übergeben werden (bei Array wird das automatisch ermittelt)
	$rows = \nn\t3::Db()->statement( 'SELECT  FROM tt_news WHERE uid IN (:uids)', ['uids'=>[1,2,3]], ['uids'=>Connection::PARAM_INT_ARRAY] );

Bei einem ``SELECT`` Statement werden die Zeilen aus der Datenbank als Array zurückgegeben.
Bei allen anderen Statements (z.B. ``UPDATE`` oder ``DELETE``) wird die Anzahl der betroffenen Zeilen zurückgegeben.

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
   

