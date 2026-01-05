
.. include:: ../../../../Includes.txt

.. _Encrypt-getSaltingKey:

==============================================
Encrypt::getSaltingKey()
==============================================

\\nn\\t3::Encrypt()->getSaltingKey();
----------------------------------------------

Holt den Enryption / Salting Key aus der Extension Konfiguration für ``nnhelpers``.
Falls im Extension Manager noch kein Key gesetzt wurde, wird er automatisch generiert
und in der ``LocalConfiguration.php`` gespeichert.

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
   

