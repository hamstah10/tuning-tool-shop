
.. include:: ../../../../Includes.txt

.. _Encrypt-decode:

==============================================
Encrypt::decode()
==============================================

\\nn\\t3::Encrypt()->decode(``$data = ''``);
----------------------------------------------

Entschlüsselt einen String oder ein Array.
Zum Verschlüsseln der Daten kann ``\nn\t3::Encrypt()->encode()`` verwendet werden.
Siehe ``\nn\t3::Encrypt()->encode()`` für ein komplettes Beispiel.

.. code-block:: php

	\nn\t3::Encrypt()->decode( '...' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function decode( $data = '' ) {
   	[$key1, $key2] = json_decode(base64_decode( $this->getSaltingKey() ), true);
   	$mix = base64_decode($data);
   	$method = self::ENCRYPTION_METHOD;
   	$iv_length = openssl_cipher_iv_length($method);
   	$iv = substr($mix, 0, $iv_length);
   	$second_encrypted = substr($mix, $iv_length, 64);
   	$first_encrypted = substr($mix, $iv_length + 64);
   	$data = openssl_decrypt($first_encrypted, $method, base64_decode($key1), OPENSSL_RAW_DATA, $iv);
   	$second_encrypted_new = hash_hmac(self::ENCRYPTION_HMAC, $first_encrypted, base64_decode($key2), TRUE);
   	if (hash_equals($second_encrypted, $second_encrypted_new)) {
   		$data = json_decode( $data, true );
   		return $data['_'] ?? null;
   	}
   	return false;
   }
   

