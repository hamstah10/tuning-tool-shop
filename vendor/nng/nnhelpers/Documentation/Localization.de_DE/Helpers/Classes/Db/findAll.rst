
.. include:: ../../../../Includes.txt

.. _Db-findAll:

==============================================
Db::findAll()
==============================================

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
----------------------------------------------

Holt ALLE Eintrag aus einer Datenbank-Tabelle.

Die Daten werden als Array zurückgegeben – das ist (leider) noch immer die absolute
performanteste Art, viele Datensätze aus einer Tabelle zu holen, da kein ``DataMapper``
die einzelnen Zeilen parsen muss.

.. code-block:: php

	// Alle Datensätze holen. "hidden" wird berücksichtigt.
	\nn\t3::Db()->findAll('fe_users');
	
	// Auch Datensätze holen, die "hidden" sind
	\nn\t3::Db()->findAll('fe_users', true);

| ``@param string $table``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findAll( $table = '', $ignoreEnableFields = false )
   {
   	$rows = $this->findByValues( $table, [], false, $ignoreEnableFields );
   	return $rows ?: [];
   }
   

