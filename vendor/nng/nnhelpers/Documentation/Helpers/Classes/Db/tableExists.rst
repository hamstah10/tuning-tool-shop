
.. include:: ../../../../Includes.txt

.. _Db-tableExists:

==============================================
Db::tableExists()
==============================================

\\nn\\t3::Db()->tableExists(``$table = ''``);
----------------------------------------------

Does a specific DB table exist?

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
   

