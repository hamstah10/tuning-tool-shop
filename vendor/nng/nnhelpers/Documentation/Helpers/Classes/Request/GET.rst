
.. include:: ../../../../Includes.txt

.. _Request-GET:

==============================================
Request::GET()
==============================================

\\nn\\t3::Request()->GET(``$url = '', $queryParams = [], $headers = [], $dontNestArrays = false``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function GET( $url = '', $queryParams = [], $headers = [], $dontNestArrays = false )
   {
   	// ['Accept-Encoding'=>'gzip'] --> ['Accept-Encoding: gzip']
   	array_walk( $headers, function (&$v, $k) {
   		if (!is_numeric($k)) $v = $k . ': ' . $v;
   	});
   	$headers = array_values($headers);
   	$url = $this->mergeGetParams($url, $queryParams, $dontNestArrays);
   	$ch = curl_init();
   	curl_setopt($ch, CURLOPT_URL, $url );
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
   	// follow redirects
   	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   	$result = curl_exec($ch);
   	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   	$error = curl_error($ch);
   	curl_close($ch);
   	if ($httpcode >= 300) {
   		return [
   			'error'		=> true,
   			'status' 	=> $httpcode,
   			'content'	=> $error,
   			'response'	=> @json_decode($result, true) ?: $result,
   		];
   	}
   	return [
   		'error'		=> false,
   		'status' 	=> 200,
   		'content' 	=> $result,
   	];
   }
   

