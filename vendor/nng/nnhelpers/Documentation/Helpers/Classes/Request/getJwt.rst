
.. include:: ../../../../Includes.txt

.. _Request-getJwt:

==============================================
Request::getJwt()
==============================================

\\nn\\t3::Request()->getJwt();
----------------------------------------------

Read the JWT (Json Web Token) from the request, validate it and, if the signature is
successfully check the signature and return the payload of the JWT.

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
   

