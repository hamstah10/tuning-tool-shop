
.. include:: ../../../../Includes.txt

.. _Db-truncate:

==============================================
Db::truncate()
==============================================

\\nn\\t3::Db()->truncate(``$table = ''``);
----------------------------------------------

Empty database table.
Deletes all entries in the specified table and resets the auto-increment value to ``0``.

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
   

