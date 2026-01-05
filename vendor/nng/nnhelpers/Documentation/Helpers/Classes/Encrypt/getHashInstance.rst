
.. include:: ../../../../Includes.txt

.. _Encrypt-getHashInstance:

==============================================
Encrypt::getHashInstance()
==============================================

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
----------------------------------------------

Returns the class name of the current hash algorithm of an encrypted password,
e.g. to know at fe_user how the password was encrypted in the DB.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getHashInstance( $passwordHash = '', $loginType = 'FE' ) {
   	$saltFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
   	$hashInstance = false;
   	try {
   		$hashInstance = $saltFactory->get( $passwordHash, $loginType );
   	} catch (InvalidPasswordHashException $invalidPasswordHashException) {
   		// unknown
   	}
   	return $hashInstance;
   }
   

