
.. include:: ../../../../Includes.txt

.. _Request-PUT_JSON:

==============================================
Request::PUT_JSON()
==============================================

\\nn\\t3::Request()->PUT_JSON(``$url = '', $data = [], $headers = []``);
----------------------------------------------

Sends a PUT request (via curl) to a server as JSON

.. code-block:: php

	\nn\t3::Request()->PUT_JSON( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->PUT_JSON( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function PUT_JSON( $url = '', $data = [], $headers = [] )
   {
   	return $this->POST( $url, json_encode($data), $headers, 'PUT' );
   }
   

