
.. include:: ../../../../Includes.txt

.. _Cookies-addCookiesToResponse:

==============================================
Cookies::addCookiesToResponse()
==============================================

\\nn\\t3::Cookies()->addCookiesToResponse(``$request, $response``);
----------------------------------------------

Adds all saved cookies to the PSR-7 response.
Is called by ``\Nng\Nnhelpers\Middleware\ModifyResponse``.

.. code-block:: php

	// Example in a MiddleWare:
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
   

