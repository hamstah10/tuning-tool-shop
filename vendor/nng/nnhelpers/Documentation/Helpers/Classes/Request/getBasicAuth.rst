
.. include:: ../../../../Includes.txt

.. _Request-getBasicAuth:

==============================================
Request::getBasicAuth()
==============================================

\\nn\\t3::Request()->getBasicAuth();
----------------------------------------------

Read the Basic Authorization Header from the request.
If available, the username and password are returned.

.. code-block:: php

	$credentials = \nn\t3::Request()->getBasicAuth(); // ['username'=>'...', 'password'=>'...']

Example call from a test script:

.. code-block:: php

	echo file_get_contents('https://username:password@www.testsite.com');

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getBasicAuth()
   {
   	$username = '';
   	$password = '';
   	if (isset($_SERVER['PHP_AUTH_USER'])) {
   		$username = $_SERVER['PHP_AUTH_USER'];
   		$password = $_SERVER['PHP_AUTH_PW'];
   	} else {
   		$check = ['HTTP_AUTHENTICATION', 'HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION'];
   		foreach ($check as $key) {
   			$value = $_SERVER[$key] ?? false;
   			$isBasic = strpos(strtolower($value), 'basic') === 0;
   			if ($value && $isBasic) {
   				$decodedValue = base64_decode(substr($value, 6));
   				[$username, $password] = explode(':', $decodedValue) ?: ['', ''];
   				break;
   			}
   		}
   	}
   	if (!$username && !$password) return [];
   	return ['username'=>$username, 'password'=>$password];
   }
   

