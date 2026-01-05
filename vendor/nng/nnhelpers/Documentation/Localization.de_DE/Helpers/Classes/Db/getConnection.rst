
.. include:: ../../../../Includes.txt

.. _Db-getConnection:

==============================================
Db::getConnection()
==============================================

\\nn\\t3::Db()->getConnection();
----------------------------------------------

Eine "rohe" Verbindung zur Datenbank holen.
Nur in wirklichen Ausnahmefällen sinnvoll.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT  FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getConnection()
   {
   	$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
   	$connectionName = array_shift($connectionPool->getConnectionNames());
   	return $connectionPool->getConnectionByName( $connectionName );
   }
   

