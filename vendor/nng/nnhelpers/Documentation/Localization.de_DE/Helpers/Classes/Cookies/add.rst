
.. include:: ../../../../Includes.txt

.. _Cookies-add:

==============================================
Cookies::add()
==============================================

\\nn\\t3::Cookies()->add(``$name = '', $value = '', $expire = 0``);
----------------------------------------------

Einen Cookie erzeugen - aber noch nicht an den Client senden.
Der Cookie wird erst in der Middleware gesetzt, siehe:
| ``\Nng\Nnhelpers\Middleware\ModifyResponse``

.. code-block:: php

	$cookie = \nn\t3::Cookies()->add( $name, $value, $expire );
	$cookie = \nn\t3::Cookies()->add( 'my_cookie', 'my_nice_value', time() + 60 );

| ``@param string $name``
| ``@param string $value``
| ``@param int $expire``
| ``@return Cookie``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function add ( $name = '', $value = '', $expire = 0 )
   {
   	$this->cookiesToSet[$name] = [
   		'value' => $value,
   		'expire' => $expire
   	];
   }
   

