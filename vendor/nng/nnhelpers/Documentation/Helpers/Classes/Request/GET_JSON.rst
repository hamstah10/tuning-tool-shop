
.. include:: ../../../../Includes.txt

.. _Request-GET_JSON:

==============================================
Request::GET_JSON()
==============================================

\\nn\\t3::Request()->GET_JSON(``$url = '', $queryParams = [], $headers = NULL``);
----------------------------------------------

Sends a GET request to a server and parses the result as JSON

.. code-block:: php

	\nn\t3::Request()->GET_JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function GET_JSON( $url = '', $queryParams = [], $headers = null )
   {
   	if ($headers === null) {
   		$headers = ['Accept' => 'application/json'];
   	}
   	$result = $this->GET( $url, $queryParams, $headers );
   	return @json_decode($result['content'], true) ?: $result['content'];
   }
   

