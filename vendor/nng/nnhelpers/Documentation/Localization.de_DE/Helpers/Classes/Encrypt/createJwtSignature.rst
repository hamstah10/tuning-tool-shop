
.. include:: ../../../../Includes.txt

.. _Encrypt-createJwtSignature:

==============================================
Encrypt::createJwtSignature()
==============================================

\\nn\\t3::Encrypt()->createJwtSignature(``$header = [], $payload = []``);
----------------------------------------------

Signatur für ein JWT (Json Web Token) erzeugen.
Die Signatur wird später als Teil des Tokens mit vom User übertragen.

.. code-block:: php

	$signature = \nn\t3::Encrypt()->createJwtSignature(['alg'=>'HS256', 'typ'=>'JWT'], ['test'=>123]);

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
   

