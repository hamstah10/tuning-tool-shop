
.. include:: ../../../Includes.txt

.. _Storage:

==============================================
Storage
==============================================

\\nn\\t3::Storage()
----------------------------------------------

Alles rund um Storages

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Storage()->clearStorageRowCache();
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den StorageRowCache

.. code-block:: php

	    \nn\t3::Storage()->clearStorageRowCache();

| ``@return void``

| :ref:`➜ Go to source code of Storage::clearStorageRowCache() <Storage-clearStorageRowCache>`

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den \Folder-Object für einen Zielordner (oder Datei) innerhalb einer Storage zurück.
Legt Ordner an, falls er noch nicht existiert

Beispiele:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/beispiel.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==>  gibt \Folder-Object für den Ordner 'test/' zurück

| ``@return Folder``

| :ref:`➜ Go to source code of Storage::getFolder() <Storage-getFolder>`

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Im Controller: Aktuelle StoragePid für ein PlugIn holen.
Alias zu ``\nn\t3::Settings()->getStoragePid()``

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
