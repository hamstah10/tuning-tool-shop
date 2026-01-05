
.. include:: ../../../../Includes.txt

.. _Encrypt-password:

==============================================
Encrypt::password()
==============================================

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
----------------------------------------------

Hashing eines Passwortes nach Typo3-Prinzip.
Anwendung: Passwort eines fe_users in der Datenbank überschreiben

.. code-block:: php

	\nn\t3::Encrypt()->password('99grad');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function password ( $clearTextPassword = '', $context = 'FE' ) {
   	$hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance( $context );
   	$saltedPassword = $hashInstance->getHashedPassword( $clearTextPassword );
   	return $saltedPassword;
   }
   

