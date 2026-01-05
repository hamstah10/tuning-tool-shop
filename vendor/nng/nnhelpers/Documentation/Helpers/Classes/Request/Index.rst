
.. include:: ../../../Includes.txt

.. _Request:

==============================================
Request
==============================================

\\nn\\t3::Request()
----------------------------------------------

Access to GET / POST variables, file containers etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Request()->DELETE(``$url = '', $queryParams = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a DELETE request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->DELETE( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->DELETE( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::DELETE() <Request-DELETE>`

\\nn\\t3::Request()->GET(``$url = '', $queryParams = [], $headers = [], $dontNestArrays = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a GET request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );
	
	// if 'a'=>[1,2,3] should be sent as a=1&a=2&a=3 instead of a[]=1&a[]=2&a[]=3
	 \nn\t3::Request()->GET( 'https://...', ['a'=>[1,2,3]], [], true );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::GET() <Request-GET>`

\\nn\\t3::Request()->GET_JSON(``$url = '', $queryParams = [], $headers = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a GET request to a server and parses the result as JSON

.. code-block:: php

	\nn\t3::Request()->GET_JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::GET_JSON() <Request-GET_JSON>`

\\nn\\t3::Request()->GP(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge from $_GET and $_POST variables

.. code-block:: php

	\nn\t3::Request()->GP();

| ``@return array``

| :ref:`➜ Go to source code of Request::GP() <Request-GP>`

\\nn\\t3::Request()->JSON(``$url = '', $data = [], $headers = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a JSON to a server via POST

.. code-block:: php

	\nn\t3::Request()->JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array|null $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::JSON() <Request-JSON>`

\\nn\\t3::Request()->POST(``$url = '', $postData = [], $headers = [], $requestType = 'POST'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a POST request (via CURL) to a server.

.. code-block:: php

	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $postData``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::POST() <Request-POST>`

\\nn\\t3::Request()->PUT(``$url = '', $data = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a PUT request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->PUT( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->PUT( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::PUT() <Request-PUT>`

\\nn\\t3::Request()->PUT_JSON(``$url = '', $data = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a PUT request (via curl) to a server as JSON

.. code-block:: php

	\nn\t3::Request()->PUT_JSON( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->PUT_JSON( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::PUT_JSON() <Request-PUT_JSON>`

\\nn\\t3::Request()->files(``$path = NULL, $forceArray = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get and normalize file uploads from ``$_FILES``.

Normalizes the following file upload variants.
Removes empty file uploads from the array.

.. code-block:: php

	
	
	
	

Examples:
 ``Get``ALL file info from ``$_FILES``.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // Force array

Get file info from ``tx_nnfesubmit_nnfesubmit[...]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true); // Force array

Only get files from ``tx_nnfesubmit_nnfesubmit[fal_media]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Force array

| ``@return array``

| :ref:`➜ Go to source code of Request::files() <Request-files>`

\\nn\\t3::Request()->getAuthorizationHeader();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the Authorization header from the request.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Important: If this does not work, the following line is probably missing in the .htaccess
is probably missing the following line:

.. code-block:: php

	# nnhelpers: Use when PHP is executed in PHP CGI mode
	RewriteRule . - E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

| ``@return string``

| :ref:`➜ Go to source code of Request::getAuthorizationHeader() <Request-getAuthorizationHeader>`

\\nn\\t3::Request()->getBasicAuth();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the Basic Authorization Header from the request.
If available, the username and password are returned.

.. code-block:: php

	$credentials = \nn\t3::Request()->getBasicAuth(); // ['username'=>'...', 'password'=>'...']

Example call from a test script:

.. code-block:: php

	echo file_get_contents('https://username:password@www.testsite.com');

| ``@return array``

| :ref:`➜ Go to source code of Request::getBasicAuth() <Request-getBasicAuth>`

\\nn\\t3::Request()->getBearerToken();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the ``bearer header``
Is used, among other things, to transmit a JWT (Json Web Token).

.. code-block:: php

	\nn\t3::Request()->getBearerToken();

| ``@return string|null``

| :ref:`➜ Go to source code of Request::getBearerToken() <Request-getBearerToken>`

\\nn\\t3::Request()->getJwt();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the JWT (Json Web Token) from the request, validate it and, if the signature is
successfully check the signature and return the payload of the JWT.

.. code-block:: php

	\nn\t3::Request()->getJwt();

| ``@return array|string``

| :ref:`➜ Go to source code of Request::getJwt() <Request-getJwt>`

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Return the request URI. Basically the URL / the GET string
in the browser URL bar, which is stored in ``$_SERVER['REQUEST_URI']``
is saved.

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

| :ref:`➜ Go to source code of Request::getUri() <Request-getUri>`

\\nn\\t3::Request()->mergeGetParams(``$url = '', $getParams = [], $dontNestArrays = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

| ``@param string $url``
| ``@param array $getParams``
| ``@param bool $dontNestArrays``
| ``@return string``

| :ref:`➜ Go to source code of Request::mergeGetParams() <Request-mergeGetParams>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
