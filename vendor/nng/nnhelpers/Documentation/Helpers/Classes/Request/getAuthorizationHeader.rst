
.. include:: ../../../../Includes.txt

.. _Request-getAuthorizationHeader:

==============================================
Request::getAuthorizationHeader()
==============================================

\\nn\\t3::Request()->getAuthorizationHeader();
----------------------------------------------

Read the Authorization header from the request.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Important: If this does not work, the following line is probably missing in the .htaccess
is probably missing the following line:

.. code-block:: php

	# nnhelpers: Use when PHP is executed in PHP CGI mode
	RewriteRule . - E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

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
   

