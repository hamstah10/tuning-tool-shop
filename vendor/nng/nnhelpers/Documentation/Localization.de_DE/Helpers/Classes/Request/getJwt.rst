
.. include:: ../../../../Includes.txt

.. _Request-getJwt:

==============================================
Request::getJwt()
==============================================

\\nn\\t3::Request()->getJwt();
----------------------------------------------

Den JWT (Json Web Token) aus dem Request auslesen, validieren und bei
erfolgreichem Prüfen der Signatur den Payload des JWT zurückgeben.

.. code-block:: php

	\nn\t3::Request()->getJwt();

| ``@return array|string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getJwt()
   {
   	$jwt = $this->getBearerToken();
   	return \nn\t3::Encrypt()->parseJwt($jwt);
   }
   

