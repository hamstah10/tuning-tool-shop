
.. include:: ../../../Includes.txt

.. _Cookies:

==============================================
Cookies
==============================================

\\nn\\t3::Cookies()
----------------------------------------------

Methoden zum Setzen eines Cookies.

Seit TYPO3 12 können Cookies nicht einfach über ``$_COOKIE[]`` gesetzt werden.
Sie müssen stattdessen im ``Psr\Http\Message\ResponseInterface`` gesetzt werden.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cookies()->add(``$name = '', $value = '', $expire = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cookies::add() <Cookies-add>`

\\nn\\t3::Cookies()->addCookiesToResponse(``$request, $response``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt alle gespeicherten Cookies an den PSR-7 Response.
Wird von ``\Nng\Nnhelpers\Middleware\ModifyResponse`` aufgerufen.

.. code-block:: php

	// Beispiel in einer MiddleWare:
	$response = $handler->handle($request);
	\nn\t3::Cookies()->addCookiesToResponse( $request, $response );

| ``@param ServerRequestInterface $request``
| ``@param ResponseInterface $request``

| :ref:`➜ Go to source code of Cookies::addCookiesToResponse() <Cookies-addCookiesToResponse>`

\\nn\\t3::Cookies()->create(``$request = NULL, $name = '', $value = '', $expire = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Instanz des Symfony-Cookies erzeugen

.. code-block:: php

	$cookie = \nn\t3::Cookies()->create( $request, $name, $value, $expire );
	$cookie = \nn\t3::Cookies()->create( $request, 'my_cookie', 'my_nice_value', time() + 60 );

| ``@param ServerRequestInterface $request``
| ``@param string $name``
| ``@param string $value``
| ``@param int $expire``
| ``@return Cookie``

| :ref:`➜ Go to source code of Cookies::create() <Cookies-create>`

\\nn\\t3::Cookies()->getAll();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt alle Cookies zurück, die darauf warten, in der Middleware
beim Response gesetzt zu werden.

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
