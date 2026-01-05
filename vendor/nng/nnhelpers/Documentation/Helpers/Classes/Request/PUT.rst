
.. include:: ../../../../Includes.txt

.. _Request-PUT:

==============================================
Request::PUT()
==============================================

\\nn\\t3::Request()->PUT(``$url = '', $data = [], $headers = []``);
----------------------------------------------

Sends a PUT request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->PUT( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->PUT( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function PUT( $url = '', $data = [], $headers = [] )
   {
   	return $this->POST( $url, $data, $headers, 'PUT' );
   }
   

