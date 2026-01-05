
.. include:: ../../../../Includes.txt

.. _Db-tableExists:

==============================================
Db::tableExists()
==============================================

\\nn\\t3::Db()->tableExists(``$table = ''``);
----------------------------------------------

Existiert eine bestimmte DB-Tabelle?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function tableExists ( $table = '' )
   {
   	return isset($GLOBALS['TCA'][$table]);
   }
   

