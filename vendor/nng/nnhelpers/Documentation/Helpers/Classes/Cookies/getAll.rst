
.. include:: ../../../../Includes.txt

.. _Cookies-getAll:

==============================================
Cookies::getAll()
==============================================

\\nn\\t3::Cookies()->getAll();
----------------------------------------------

Returns all cookies that are waiting to be set in the middleware
to be set in the response.

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
   

