
.. include:: ../../../../Includes.txt

.. _Storage-clearStorageRowCache:

==============================================
Storage::clearStorageRowCache()
==============================================

\\nn\\t3::Storage()->clearStorageRowCache();
----------------------------------------------

Deletes the StorageRowCache

.. code-block:: php

	    \nn\t3::Storage()->clearStorageRowCache();

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearStorageRowCache ()
   {
   	$this->storageRowCache = NULL;
   	$this->initializeLocalCache();
   }
   

