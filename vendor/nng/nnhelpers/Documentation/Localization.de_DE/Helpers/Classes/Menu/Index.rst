
.. include:: ../../../Includes.txt

.. _Menu:

==============================================
Menu
==============================================

\\nn\\t3::Menu()
----------------------------------------------

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Menu()->get(``$rootPid = NULL, $config = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt ein Array mit hierarchischer Baum-Struktur der Navigation
zurück. Kann zum Rendern eines Menüs genutzt werden.

.. code-block:: php

	// Struktur für aktuelle Seiten-ID (pid) holen
	\nn\t3::Menu()->get();
	
	// Struktur für Seite 123 holen
	\nn\t3::Menu()->get( 123 );

Es gibt auch einen ViewHelper dazu:

.. code-block:: php

	{nnt3:menu.directory(pageUid:123, ...)}

| ``@param int $rootPid``
| ``@param array $config``
| ``@return mixed``

| :ref:`➜ Go to source code of Menu::get() <Menu-get>`

\\nn\\t3::Menu()->getRootline(``$rootPid = NULL, $config = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt einfaches Array mit der Rootline zur aktuellen Seite.
Kann für BreadCrumb-Navigationen genutzt werden

.. code-block:: php

	// rootline für aktuelle Seiten-ID (pid) holen
	\nn\t3::Menu()->getRootline();
	
	// rootline für Seite 123 holen
	\nn\t3::Menu()->getRootline( 123 );

Es gibt auch einen ViewHelper dazu:

.. code-block:: php

	{nnt3:menu.rootline(pageUid:123, ...)}

| ``@param int $rootPid``
| ``@param array $config``
| ``@return mixed``

| :ref:`➜ Go to source code of Menu::getRootline() <Menu-getRootline>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
