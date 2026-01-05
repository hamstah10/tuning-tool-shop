
.. include:: ../../../../Includes.txt

.. _Request-DELETE:

==============================================
Request::DELETE()
==============================================

\\nn\\t3::Request()->DELETE(``$url = '', $queryParams = [], $headers = []``);
----------------------------------------------

Sends a DELETE request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->DELETE( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->DELETE( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function DELETE( $url = '', $queryParams = [], $headers = [] )
   {
   	// ['Accept-Encoding'=>'gzip'] --> ['Accept-Encoding: gzip']
   	array_walk( $headers, function (&$v, $k) {
   		if (!is_numeric($k)) $v = $k . ': ' . $v;
   	});
   	$headers = array_values($headers);
   	$url = $this->mergeGetParams($url, $queryParams);
   	$ch = curl_init();
   	curl_setopt($ch, CURLOPT_URL, $url );
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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
   

