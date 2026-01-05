
.. include:: ../../../../Includes.txt

.. _Request-getAuthorizationHeader:

==============================================
Request::getAuthorizationHeader()
==============================================

\\nn\\t3::Request()->getAuthorizationHeader();
----------------------------------------------

Den Authorization-Header aus dem Request auslesen.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Wichtig: Wenn das hier nicht funktioniert, fehlt in der .htaccess
wahrscheinlich folgende Zeile:

.. code-block:: php

	# nnhelpers: Verwenden, wenn PHP im PHP-CGI-Mode ausgeführt wird
	RewriteRule . - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAuthorizationHeader()
   {
   	$headers = null;
   	if (isset($_SERVER['Authorization'])) {
   		$headers = trim($_SERVER['Authorization']);
   	} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
   		$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
   	} elseif (function_exists('apache_request_headers')) {
   		$requestHeaders = apache_request_headers();
   		foreach ($requestHeaders as $k=>$v) {
   			$requestHeaders[ucwords($k)] = $v;
   		}
   		if (isset($requestHeaders['Authorization'])) {
   			$headers = trim($requestHeaders['Authorization']);
   		}
   	}
   	return $headers;
   }
   

