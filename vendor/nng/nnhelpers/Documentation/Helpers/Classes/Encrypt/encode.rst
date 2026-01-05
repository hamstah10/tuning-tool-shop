
.. include:: ../../../../Includes.txt

.. _Encrypt-encode:

==============================================
Encrypt::encode()
==============================================

\\nn\\t3::Encrypt()->encode(``$data = ''``);
----------------------------------------------

Encrypts a string or an array.

In contrast to ``\nn\t3::Encrypt()->hash()``, an encrypted value can be decrypted again using ``\nn\t3::Encrypt()->decode()``
can be decrypted again. This method is therefore not suitable for storing sensitive data such as passwords
in a database. Nevertheless, the level of protection is relatively high, as even identical data encrypted with
encrypted with the same salting key look different.

A salting key is generated for the encryption and stored in the ``nnhelpers`` Extension Manager.
This key is unique for each installation. If it is changed, data that has already been encrypted cannot be
be decrypted again.

.. code-block:: php

	\nn\t3::Encrypt()->encode( 'mySecretSomething' );
	\nn\t3::Encrypt()->encode( ['some'=>'secret'] );

Complete example with encryption and decryption:

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
   

