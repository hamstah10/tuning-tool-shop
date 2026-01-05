
.. include:: ../../../../Includes.txt

.. _Menu-getRootline:

==============================================
Menu::getRootline()
==============================================

\\nn\\t3::Menu()->getRootline(``$rootPid = NULL, $config = []``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRootline( $rootPid = null, $config = [] )
   {
   	$config['type'] = 'rootline';
   	return $this->get( $rootPid, $config )['children'];
   }
   

