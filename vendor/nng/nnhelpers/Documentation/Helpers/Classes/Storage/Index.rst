
.. include:: ../../../Includes.txt

.. _Storage:

==============================================
Storage
==============================================

\\nn\\t3::Storage()
----------------------------------------------

Everything about Storages

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Storage()->clearStorageRowCache();
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the StorageRowCache

.. code-block:: php

	    \nn\t3::Storage()->clearStorageRowCache();

| ``@return void``

| :ref:`➜ Go to source code of Storage::clearStorageRowCache() <Storage-clearStorageRowCache>`

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the \Folder object for a target folder (or file) within a storage.
Creates a folder if it does not yet exist

Examples:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/example.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==> returns \Folder object for the folder 'test/'

| ``@return Folder``

| :ref:`➜ Go to source code of Storage::getFolder() <Storage-getFolder>`

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

In the controller: Get current StoragePid for a plug-in.
Alias to ``\nn\t3::Settings()->getStoragePid()``

.. code-block:: php

	\nn\t3::Storage()->getPid();
	\nn\t3::Storage()->getPid('news');

| ``@return string``

| :ref:`➜ Go to source code of Storage::getPid() <Storage-getPid>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
