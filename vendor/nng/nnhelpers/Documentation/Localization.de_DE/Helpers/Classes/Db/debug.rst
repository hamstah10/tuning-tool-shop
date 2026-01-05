
.. include:: ../../../../Includes.txt

.. _Db-debug:

==============================================
Db::debug()
==============================================

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
----------------------------------------------

Debug des ``QueryBuilder``-Statements.

Gibt den kompletten, kompilierten Query als lesbaren String aus, so wie er später in der Datenbank
ausgeführt wird z.B. ``SELECT  FROM fe_users WHERE ...``

.. code-block:: php

	// Statement direkt im Browser ausgeben
	\nn\t3::Db()->debug( $query );
	
	// Statement als String zurückgeben, nicht automatisch ausgeben
	echo \nn\t3::Db()->debug( $query, true );

| ``@param mixed $query``
| ``@param boolean $return``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function debug ( $query = null, $return = false )
   {
   	if( !($query instanceof QueryBuilder) ) {
   		$queryParser = \nn\t3::injectClass(Typo3DbQueryParser::class);
   		$query = $queryParser->convertQueryToDoctrineQueryBuilder($query);
   	}
   	$dcValues = $query->getParameters();
   	$dcValuesFull = [];
   	foreach ($dcValues as $k=>$v) {
   		if (is_array($v)) {
   			foreach ($v as &$n) {
   				if (!is_numeric($n)) {
   					$n = "'" . addslashes($n) . "'";
   				}
   			}
   			$v = join(',', $v);
   		} else if (!is_numeric($v)) {
   			$v = "'" . addslashes($v) . "'";
   		}
   		$dcValuesFull[":{$k}"] = $v;
   	}
   	// Sicherstellen, dass zuerst `:value55` vor `:value5` ersetzt wird
   	uksort($dcValuesFull, function($a, $b) {
   		return strlen($a) > strlen($b) ? -1 : 1;
   	});
   	$str = $query->getSQL();
   	$str = str_replace( array_keys($dcValuesFull), array_values($dcValuesFull), $str );
   	if (!$return) echo $str;
   	return $str;
   }
   

