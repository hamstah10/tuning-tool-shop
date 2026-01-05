
.. include:: ../../../../Includes.txt

.. _Encrypt-getHashInstance:

==============================================
Encrypt::getHashInstance()
==============================================

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
----------------------------------------------

Gibt den Klassen-Names des aktuellen Hash-Algorithmus eines verschlüsselten Passwortes wieder,
z.B. um beim fe_user zu wissen, wie das Passwort in der DB verschlüsselt wurde.

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
   

