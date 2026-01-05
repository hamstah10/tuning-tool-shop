
.. include:: ../../../../Includes.txt

.. _Encrypt-jwt:

==============================================
Encrypt::jwt()
==============================================

\\nn\\t3::Encrypt()->jwt(``$payload = []``);
----------------------------------------------

Create a JWT (Json Web Token), sign it and return it ``base64-encoded``.

Do not forget: A JWT is "forgery-proof" because the signature hash can only be generated with
can only be generated with the correct key/salt - but all data in the JWT can be read by anyone
can be viewed through ``base64_decode()``. A JWT is by no means suitable for storing sensitive data such as
passwords or logins!

.. code-block:: php

	\nn\t3::Encrypt()->jwt(['test'=>123]);

| ``@param array $payload``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function jwt( $payload = [] ) {
   	$header = [
   		'alg' => 'HS256',
   		'typ' => 'JWT',
   	];
   	$signature = $this->createJwtSignature($header, $payload);
   	return join('.', [
   		base64_encode(json_encode($header)),
   		base64_encode(json_encode($payload)),
   		base64_encode($signature)
   	]);
   }
   

