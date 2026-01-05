
.. include:: ../../../../Includes.txt

.. _Cookies-addCookiesToResponse:

==============================================
Cookies::addCookiesToResponse()
==============================================

\\nn\\t3::Cookies()->addCookiesToResponse(``$request, $response``);
----------------------------------------------

Fügt alle gespeicherten Cookies an den PSR-7 Response.
Wird von ``\Nng\Nnhelpers\Middleware\ModifyResponse`` aufgerufen.

.. code-block:: php

	// Beispiel in einer MiddleWare:
	$response = $handler->handle($request);
	\nn\t3::Cookies()->addCookiesToResponse( $request, $response );

| ``@param ServerRequestInterface $request``
| ``@param ResponseInterface $request``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addCookiesToResponse ( $request, &$response )
   {
   	foreach ($this->cookiesToSet as $name=>$cookie) {
   		$cookie = $this->create( $request, $name, $cookie['value'], $cookie['expire'] );
   		$response = $response->withAddedHeader('Set-Cookie', (string) $cookie);
   	}
   	return $response;
   }
   

