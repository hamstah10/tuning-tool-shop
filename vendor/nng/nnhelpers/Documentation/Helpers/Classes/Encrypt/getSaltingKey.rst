
.. include:: ../../../../Includes.txt

.. _Encrypt-getSaltingKey:

==============================================
Encrypt::getSaltingKey()
==============================================

\\nn\\t3::Encrypt()->getSaltingKey();
----------------------------------------------

Retrieves the Enryption / Salting Key from the extension configuration for ``nnhelpers``
If no key has been set in the Extension Manager, it is generated automatically
and saved in the ``LocalConfiguration.php``.

.. code-block:: php

	\nn\t3::Encrypt()->getSaltingKey();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSaltingKey() {
   	if ($key = \nn\t3::Settings()->getExtConf('nnhelpers')['saltingKey'] ?? false) {
   		return $key;
   	}
   	$key = base64_encode(json_encode([
   		base64_encode(openssl_random_pseudo_bytes(32)),
   		base64_encode(openssl_random_pseudo_bytes(64))
   	]));
   	if (!\nn\t3::Settings()->setExtConf( 'nnhelpers', 'saltingKey', $key)) {
   		\nn\t3::Exception('Please first set the encryption key in the Extension-Manager for nnhelpers!');
   	}
   	return $key;
   }
   

