
.. include:: ../../../../Includes.txt

.. _Request-JSON:

==============================================
Request::JSON()
==============================================

\\nn\\t3::Request()->JSON(``$url = '', $data = [], $headers = NULL``);
----------------------------------------------

Sendet ein JSON per POST an einen Server

.. code-block:: php

	\nn\t3::Request()->JSON( 'https://...', ['a'=>'123'] );

| ``@param string $url``
| ``@param array $data``
| ``@param array|null $headers``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function JSON( $url = '', $data = [], $headers = null )
   {
   	if ($headers === null) {
   		$headers = ['Content-Type' => 'application/json'];
   	}
   	return $this->POST( $url, json_encode($data), $headers );
   }
   

