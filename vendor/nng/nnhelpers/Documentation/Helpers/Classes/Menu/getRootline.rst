
.. include:: ../../../../Includes.txt

.. _Menu-getRootline:

==============================================
Menu::getRootline()
==============================================

\\nn\\t3::Menu()->getRootline(``$rootPid = NULL, $config = []``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRootline( $rootPid = null, $config = [] )
   {
   	$config['type'] = 'rootline';
   	return $this->get( $rootPid, $config )['children'];
   }
   

