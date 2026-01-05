
.. include:: ../../../../Includes.txt

.. _Encrypt-createJwtSignature:

==============================================
Encrypt::createJwtSignature()
==============================================

\\nn\\t3::Encrypt()->createJwtSignature(``$header = [], $payload = []``);
----------------------------------------------

Generate a signature for a JWT (Json Web Token).
The signature is later transmitted by the user as part of the token.

.. code-block:: php

	$signature = \nn\t3::Encrypt()->createJwtSignature(['alg'=>'HS256', 'type'=>'JWT'], ['test'=>123]);

| ``@param array $header``
| ``@param array $payload``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createJwtSignature( $header = [], $payload = [] ) {
   	return hash_hmac(
   		'sha256',
   		base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($payload)),
   		$this->getSaltingKey()
   	);
   }
   

