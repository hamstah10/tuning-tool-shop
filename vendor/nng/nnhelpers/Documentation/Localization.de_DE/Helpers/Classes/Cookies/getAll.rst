
.. include:: ../../../../Includes.txt

.. _Cookies-getAll:

==============================================
Cookies::getAll()
==============================================

\\nn\\t3::Cookies()->getAll();
----------------------------------------------

Gibt alle Cookies zurück, die darauf warten, in der Middleware
beim Response gesetzt zu werden.

.. code-block:: php

	$cookies = \nn\t3::Cookies()->getAll();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAll ()
   {
   	return $this->cookiesToSet;
   }
   

