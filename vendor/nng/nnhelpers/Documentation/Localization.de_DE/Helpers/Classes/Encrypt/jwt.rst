
.. include:: ../../../../Includes.txt

.. _Encrypt-jwt:

==============================================
Encrypt::jwt()
==============================================

\\nn\\t3::Encrypt()->jwt(``$payload = []``);
----------------------------------------------

Ein JWT (Json Web Token) erzeugen, signieren und ``base64``-Encoded zurückgeben.

Nicht vergessen: Ein JWT ist zwar "fälschungssicher", weil der Signatur-Hash nur mit
dem korrekten Key/Salt erzeugt werden kann – aber alle Daten im JWT sind für jeden
durch ``base64_decode()`` einsehbar. Ein JWT eignet sich keinesfalls, um sensible Daten wie
Passwörter oder Logins zu speichern!

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
   

