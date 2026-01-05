
.. include:: ../../../../Includes.txt

.. _Encrypt-password:

==============================================
Encrypt::password()
==============================================

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
----------------------------------------------

Hashing a password according to the Typo3 principle.
Application: Overwriting the password of a fe_user in the database

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
   

