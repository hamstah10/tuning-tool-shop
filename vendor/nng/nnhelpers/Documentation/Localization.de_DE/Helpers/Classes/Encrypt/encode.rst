
.. include:: ../../../../Includes.txt

.. _Encrypt-encode:

==============================================
Encrypt::encode()
==============================================

\\nn\\t3::Encrypt()->encode(``$data = ''``);
----------------------------------------------

Verschlüsselt einen String oder ein Array.

Im Gegensatz zu ``\nn\t3::Encrypt()->hash()`` kann ein verschlüsselter Wert per ``\nn\t3::Encrypt()->decode()``
wieder entschlüsselt werden. Diese Methods eignet sich daher nicht, um sensible Daten wie z.B. Passworte
in einer Datenbank zu speichern. Dennoch ist der Schutz relativ hoch, da selbst identische Daten, die mit
dem gleichen Salting-Key verschlüsselt wurden, unterschiedlich aussehen.

Für die Verschlüsselung wird ein Salting Key generiert und in dem Extension Manager von ``nnhelpers`` gespeichert.
Dieser Key ist für jede Installation einmalig. Wird er verändert, dann können bereits verschlüsselte Daten nicht
wieder entschlüsselt werden.

.. code-block:: php

	\nn\t3::Encrypt()->encode( 'mySecretSomething' );
	\nn\t3::Encrypt()->encode( ['some'=>'secret'] );

Komplettes Beispiel mit Verschlüsselung und Entschlüsselung:

.. code-block:: php

	$encryptedResult = \nn\t3::Encrypt()->encode( ['password'=>'mysecretsomething'] );
	echo \nn\t3::Encrypt()->decode( $encryptedResult )['password'];
	
	$encryptedResult = \nn\t3::Encrypt()->encode( 'some_secret_phrase' );
	echo \nn\t3::Encrypt()->decode( $encryptedResult );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function encode( $data = '' ) {
   	[$key1, $key2] = json_decode(base64_decode( $this->getSaltingKey() ), true);
   	$data = json_encode(['_'=>$data]);
   	$method = self::ENCRYPTION_METHOD;
   	$iv_length = openssl_cipher_iv_length($method);
   	$iv = openssl_random_pseudo_bytes($iv_length);
   	$first_encrypted = openssl_encrypt($data, $method, base64_decode($key1), OPENSSL_RAW_DATA, $iv);
   	$second_encrypted = hash_hmac(self::ENCRYPTION_HMAC, $first_encrypted, base64_decode($key2), TRUE);
   	$output = base64_encode($iv . $second_encrypted . $first_encrypted);
   	return $output;
   }
   

