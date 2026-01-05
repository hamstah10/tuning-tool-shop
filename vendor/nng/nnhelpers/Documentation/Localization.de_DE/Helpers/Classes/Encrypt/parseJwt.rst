
.. include:: ../../../../Includes.txt

.. _Encrypt-parseJwt:

==============================================
Encrypt::parseJwt()
==============================================

\\nn\\t3::Encrypt()->parseJwt(``$token = ''``);
----------------------------------------------

Ein JWT (Json Web Token) parsen und die Signatur überprüfen.
Falls die Signatur valide ist (und damit der Payload nicht manipuliert wurde), wird der
Payload zurückgegeben. Bei ungültiger Signatur wird ``FALSE`` zurückgegeben.

.. code-block:: php

	\nn\t3::Encrypt()->parseJwt('adhjdf.fsdfkjds.HKdfgfksfdsf');

| ``@param string $token``
| ``@return array|false``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseJwt( $token = '' ) {
   	if (!$token) return false;
   	if (substr($token, 0, 1) == '[') return false;
   	$parts = explode('.', $token);
   	if (count($parts) < 3) return false;
   	$header = json_decode(base64_decode( array_shift($parts)), true);
   	$payload = json_decode(base64_decode( array_shift($parts)), true);
   	$signature = base64_decode(array_shift($parts));
   	$checkSignature = $this->createJwtSignature($header, $payload);
   	if ($signature !== $checkSignature) return false;
   	$payload['token'] = $token;
   	return $payload;
   }
   

