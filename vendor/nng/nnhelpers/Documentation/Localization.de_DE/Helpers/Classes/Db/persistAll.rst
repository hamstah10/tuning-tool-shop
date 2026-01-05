
.. include:: ../../../../Includes.txt

.. _Db-persistAll:

==============================================
Db::persistAll()
==============================================

\\nn\\t3::Db()->persistAll();
----------------------------------------------

Alles persistieren.

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function persistAll ()
   {
   	$persistenceManager = \nn\t3::injectClass( PersistenceManager::class );
   	$persistenceManager->persistAll();
   }
   

