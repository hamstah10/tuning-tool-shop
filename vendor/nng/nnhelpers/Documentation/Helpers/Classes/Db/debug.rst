
.. include:: ../../../../Includes.txt

.. _Db-debug:

==============================================
Db::debug()
==============================================

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
----------------------------------------------

Debug of the ``QueryBuilder statement``.

Outputs the complete, compiled query as a readable string, as it is later executed in the database
executed later in the database e.g. ``SELECT FROM fe_users WHERE ...``

.. code-block:: php

	// Output statement directly in the browser
	\nn\t3::Db()->debug( $query );
	
	// Return statement as a string, do not output automatically
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
   

