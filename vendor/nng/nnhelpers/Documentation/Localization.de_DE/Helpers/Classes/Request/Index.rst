
.. include:: ../../../Includes.txt

.. _Request:

==============================================
Request
==============================================

\\nn\\t3::Request()
----------------------------------------------

Zugriff auf GET / POST Variablen, Filecontainer etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Request()->DELETE(``$url = '', $queryParams = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet einen DELETE Request (per curl) an einen Server

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

Sendet einen GET Request (per curl) an einen Server

.. code-block:: php

	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );
	
	// falls 'a'=>[1,2,3] als a=1&a=2&a=3 gesendet werdne soll, statt a[]=1&a[]=2&a[]=3
	 \nn\t3::Request()->GET( 'https://...', ['a'=>[1,2,3]], [], true );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::GET() <Request-GET>`

\\nn\\t3::Request()->GET_JSON(``$url = '', $queryParams = [], $headers = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet ein GET Request an einen Server und parsed das Ergebnis als JSON

.. code-block:: php

	\nn\t3::Request()->GET_JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::GET_JSON() <Request-GET_JSON>`

\\nn\\t3::Request()->GP(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge aus $_GET und $_POST-Variablen

.. code-block:: php

	\nn\t3::Request()->GP();

| ``@return array``

| :ref:`➜ Go to source code of Request::GP() <Request-GP>`

\\nn\\t3::Request()->JSON(``$url = '', $data = [], $headers = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet ein JSON per POST an einen Server

.. code-block:: php

	\nn\t3::Request()->JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array|null $headers``
| ``@return array``

| :ref:`➜ Go to source code of Request::JSON() <Request-JSON>`

\\nn\\t3::Request()->POST(``$url = '', $postData = [], $headers = [], $requestType = 'POST'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet einen POST Request (per CURL) an einen Server.

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

Sendet einen PUT Request (per curl) an einen Server

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

Sendet einen PUT Request (per curl) an einen Server als JSON

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

File-Uploads aus ``$_FILES`` holen und normalisieren.

Normalisiert folgende File-Upload-Varianten.
Enfernt leere Datei-Uploads aus dem Array.

.. code-block:: php

	<input name="image" type="file" />
	<input name="image[key]" type="file" />
	<input name="images[]" type="file" multiple="1" />
	<input name="images[key][]" type="file" multiple="1" />

Beispiele:
ALLE Datei-Infos aus ``$_FILES``holen.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // Array erzwingen

Datei-Infos aus ``tx_nnfesubmit_nnfesubmit[...]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true);    // Array erzwingen

Nur Dateien aus ``tx_nnfesubmit_nnfesubmit[fal_media]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Array erzwingen

| ``@return array``

| :ref:`➜ Go to source code of Request::files() <Request-files>`

\\nn\\t3::Request()->getAuthorizationHeader();
"""""""""""""""""""""""""""""""""""""""""""""""

Den Authorization-Header aus dem Request auslesen.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Wichtig: Wenn das hier nicht funktioniert, fehlt in der .htaccess
wahrscheinlich folgende Zeile:

.. code-block:: php

	# nnhelpers: Verwenden, wenn PHP im PHP-CGI-Mode ausgeführt wird
	RewriteRule . - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

| ``@return string``

| :ref:`➜ Go to source code of Request::getAuthorizationHeader() <Request-getAuthorizationHeader>`

\\nn\\t3::Request()->getBasicAuth();
"""""""""""""""""""""""""""""""""""""""""""""""

Den Basic Authorization Header aus dem Request auslesen.
Falls vorhanden, wird der Username und das Passwort zurückgeben.

.. code-block:: php

	$credentials = \nn\t3::Request()->getBasicAuth(); // ['username'=>'...', 'password'=>'...']

Beispiel-Aufruf von einem Testscript aus:

.. code-block:: php

	echo file_get_contents('https://username:password@www.testsite.com');

| ``@return array``

| :ref:`➜ Go to source code of Request::getBasicAuth() <Request-getBasicAuth>`

\\nn\\t3::Request()->getBearerToken();
"""""""""""""""""""""""""""""""""""""""""""""""

Den ``Bearer``-Header auslesen.
Wird u.a. verwendet, um ein JWT (Json Web Token) zu übertragen.

.. code-block:: php

	\nn\t3::Request()->getBearerToken();

| ``@return string|null``

| :ref:`➜ Go to source code of Request::getBearerToken() <Request-getBearerToken>`

\\nn\\t3::Request()->getJwt();
"""""""""""""""""""""""""""""""""""""""""""""""

Den JWT (Json Web Token) aus dem Request auslesen, validieren und bei
erfolgreichem Prüfen der Signatur den Payload des JWT zurückgeben.

.. code-block:: php

	\nn\t3::Request()->getJwt();

| ``@return array|string``

| :ref:`➜ Go to source code of Request::getJwt() <Request-getJwt>`

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Request-URI zurückgeben. Im Prinzip die URL / der GET-String
in der Browser URL-Leiste, der in ``$_SERVER['REQUEST_URI']``
gespeichert wird.

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
