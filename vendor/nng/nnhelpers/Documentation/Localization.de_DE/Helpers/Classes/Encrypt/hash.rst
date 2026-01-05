
.. include:: ../../../../Includes.txt

.. _Encrypt-hash:

==============================================
Encrypt::hash()
==============================================

\\nn\\t3::Encrypt()->hash(``$string = ''``);
----------------------------------------------

Einfaches Hashing, z.B. beim Check einer uid gegen ein Hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Existiert auch als ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hash( $string = '' ) {
   	$salt = $this->getSaltingKey();
   	return preg_replace('/[^a-zA-Z0-9]/', '', base64_encode( sha1("{$string}-{$salt}", true )));
   }
   

