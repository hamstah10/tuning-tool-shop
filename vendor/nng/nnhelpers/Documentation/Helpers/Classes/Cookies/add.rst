
.. include:: ../../../../Includes.txt

.. _Cookies-add:

==============================================
Cookies::add()
==============================================

\\nn\\t3::Cookies()->add(``$name = '', $value = '', $expire = 0``);
----------------------------------------------

Create a cookie - but do not send it to the client yet.
The cookie is only set in the middleware, see:
| ``\Nng\Nnhelpers\Middleware\ModifyResponse``

.. code-block:: php

	$cookie = \nn\t3::Cookies()->add( $name, $value, $expire );
	$cookie = \nn\t3::Cookies()->add( 'my_cookie', 'my_nice_value', time() + 60 );

| ``@param string $name``
| ``@param string $value``
| ``@param int $expire``
| ``@return cookie``

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
   

