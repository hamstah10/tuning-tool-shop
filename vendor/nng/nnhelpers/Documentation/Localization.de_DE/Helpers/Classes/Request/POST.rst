
.. include:: ../../../../Includes.txt

.. _Request-POST:

==============================================
Request::POST()
==============================================

\\nn\\t3::Request()->POST(``$url = '', $postData = [], $headers = [], $requestType = 'POST'``);
----------------------------------------------

Sendet einen POST Request (per CURL) an einen Server.

.. code-block:: php

	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $postData``
| ``@param array $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function POST( $url = '', $postData = [], $headers = [], $requestType = 'POST' )
   {
   	// ['Accept-Encoding'=>'gzip'] --> ['Accept-Encoding: gzip']
   	array_walk( $headers, function (&$v, $k) {
   		if (!is_numeric($k)) $v = $k . ': ' . $v;
   	});
   	if (is_array($postData)) {
   		$postData = http_build_query($postData);
   	}
   	$headers = array_values($headers);
   	$ch = curl_init();
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	curl_setopt($ch, CURLOPT_POST, 1);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData );
   	// follow redirects
   	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
   	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
   	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
   		'content' 	=> $result
   	];
   }
   

