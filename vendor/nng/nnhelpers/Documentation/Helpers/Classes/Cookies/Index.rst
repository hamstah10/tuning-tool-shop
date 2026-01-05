
.. include:: ../../../Includes.txt

.. _Cookies:

==============================================
Cookies
==============================================

\\nn\\t3::Cookies()
----------------------------------------------

Methods for setting a cookie.

Since TYPO3 12, cookies cannot simply be set via ``$_COOKIE[]``
Instead, they must be set in the ``Psr\Http\Message\ResponseInterface``.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cookies()->add(``$name = '', $value = '', $expire = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cookies::add() <Cookies-add>`

\\nn\\t3::Cookies()->addCookiesToResponse(``$request, $response``);
"""""""""""""""""""""""""""""""""""""""""""""""

Adds all saved cookies to the PSR-7 response.
Is called by ``\Nng\Nnhelpers\Middleware\ModifyResponse``.

.. code-block:: php

	// Example in a MiddleWare:
	$response = $handler->handle($request);
	\nn\t3::Cookies()->addCookiesToResponse( $request, $response );

| ``@param ServerRequestInterface $request``
| ``@param ResponseInterface $request``

| :ref:`➜ Go to source code of Cookies::addCookiesToResponse() <Cookies-addCookiesToResponse>`

\\nn\\t3::Cookies()->create(``$request = NULL, $name = '', $value = '', $expire = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create an instance of the Symfony cookie

.. code-block:: php

	$cookie = \nn\t3::Cookies()->create( $request, $name, $value, $expire );
	$cookie = \nn\t3::Cookies()->create( $request, 'my_cookie', 'my_nice_value', time() + 60 );

| ``@param ServerRequestInterface $request``
| ``@param string $name``
| ``@param string $value``
| ``@param int $expire``
| ``@return cookie``

| :ref:`➜ Go to source code of Cookies::create() <Cookies-create>`

\\nn\\t3::Cookies()->getAll();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns all cookies that are waiting to be set in the middleware
to be set in the response.

.. code-block:: php

	$cookies = \nn\t3::Cookies()->getAll();

| ``@return array``

| :ref:`➜ Go to source code of Cookies::getAll() <Cookies-getAll>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
