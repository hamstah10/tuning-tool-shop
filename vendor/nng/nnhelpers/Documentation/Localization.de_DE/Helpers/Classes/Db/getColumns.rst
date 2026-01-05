
.. include:: ../../../../Includes.txt

.. _Db-getColumns:

==============================================
Db::getColumns()
==============================================

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
----------------------------------------------

Alle Tabellen-Spalten (TCA) für bestimmte Tabelle holen

.. code-block:: php

	// Felder anhand des TCA-Arrays holen
	\nn\t3::Db()->getColumns( 'tablename' );
	
	// Felder über den SchemaManager ermitteln
	\nn\t3::Db()->getColumns( 'tablename', true );

| ``@param string $table``
| ``@param boolean $useSchemaManager``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumns ( $table = '', $useSchemaManager = false )
   {
   	$cols = isset($GLOBALS['TCA'][$table]) ? $GLOBALS['TCA'][$table]['columns'] : [];
   	// Diese Felder sind nicht ausdrücklich im TCA, aber für Abfrage legitim
   	if ($cols) {
   		$cols = \nn\t3::Arrays( $cols )->merge(['uid'=>'uid', 'pid'=>'pid', 'tstamp'=>'tstamp', 'crdate'=>'crdate', 'endtime'=>'endtime', 'starttime'=>'starttime', 'deleted'=>'deleted', 'disable'=>'disable']);
   	}
   	// Keine cols ermittelt, weil nicht  im TCA registriert – oder Abfrage erzwungen
   	if (!$cols || $useSchemaManager) {
   		$cols = GeneralUtility::makeInstance(ConnectionPool::class)
   			->getConnectionForTable($table)
   			->createSchemaManager()
   			->listTableColumns($table);
   	}
   	foreach ($cols as $k=>$v) {
   		$cols[GeneralUtility::underscoredToLowerCamelCase($k)] = $v;
   	}
   	return $cols;
   }
   

