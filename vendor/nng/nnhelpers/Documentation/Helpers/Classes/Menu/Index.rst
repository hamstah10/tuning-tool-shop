
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

Returns an array with a hierarchical tree structure of the navigation
returns. Can be used to render a menu.

.. code-block:: php

	// Get structure for current page ID (pid)
	\nn\t3::Menu()->get();
	
	// Get structure for page 123
	\nn\t3::Menu()->get( 123 );

There is also a ViewHelper for this:

.. code-block:: php

	{nnt3:menu.directory(pageUid:123, ...)}

| ``@param int $rootPid``
| ``@param array $config``
| ``@return mixed``

| :ref:`➜ Go to source code of Menu::get() <Menu-get>`

\\nn\\t3::Menu()->getRootline(``$rootPid = NULL, $config = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns a simple array with the rootline to the current page.
Can be used for BreadCrumb navigations

.. code-block:: php

	// get rootline for current page ID (pid)
	\nn\t3::Menu()->getRootline();
	
	// get rootline for page 123
	\nn\t3::Menu()->getRootline( 123 );

There is also a ViewHelper for this:

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
