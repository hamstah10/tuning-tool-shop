
.. include:: ../../../../Includes.txt

.. _Request-getBearerToken:

==============================================
Request::getBearerToken()
==============================================

\\nn\\t3::Request()->getBearerToken();
----------------------------------------------

Read the ``bearer header``
Is used, among other things, to transmit a JWT (Json Web Token).

.. code-block:: php

	\nn\t3::Request()->getBearerToken();

| ``@return string|null``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getBearerToken()
   {
   	$headers = $this->getAuthorizationHeader();
   	if (!empty($headers)) {
   		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
   			return $matches[1];
   		}
   	}
   	return null;
   }
   

