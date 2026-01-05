
.. include:: ../../../../Includes.txt

.. _Cookies-create:

==============================================
Cookies::create()
==============================================

\\nn\\t3::Cookies()->create(``$request = NULL, $name = '', $value = '', $expire = 0``);
----------------------------------------------

Create an instance of the Symfony cookie

.. code-block:: php

	$cookie = \nn\t3::Cookies()->create( $request, $name, $value, $expire );
	$cookie = \nn\t3::Cookies()->create( $request, 'my_cookie', 'my_nice_value', time() + 60 );

| ``@param ServerRequestInterface $request``
| ``@param string $name``
| ``@param string $value``
| ``@param int $expire``
| ``@return cookie``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function create ( $request = null, $name = '', $value = '', $expire = 0 )
   {
   	$normalizedParams = $request->getAttribute('normalizedParams');
   	$secure = $normalizedParams instanceof NormalizedParams && $normalizedParams->isHttps();
   	$path = $normalizedParams->getSitePath();
   	return new Cookie(
   		$name,
   		$value,
   		$expire,
   		$path,
   		null,
   		$secure,
   		true,
   		false,
   		Cookie::SAMESITE_STRICT
   	);
   }
   

