
.. include:: ../../../../Includes.txt

.. _Db-truncate:

==============================================
Db::truncate()
==============================================

\\nn\\t3::Db()->truncate(``$table = ''``);
----------------------------------------------

Datenbank-Tabelle leeren.
Löscht alle Einträge in der angegebenen Tabelle und setzt den Auto-Increment-Wert auf ``0`` zurück.

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@param string $table``
| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function truncate ( $table = '' )
   {
   	$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable( $table );
   	return $connection->truncate( $table );
   }
   

