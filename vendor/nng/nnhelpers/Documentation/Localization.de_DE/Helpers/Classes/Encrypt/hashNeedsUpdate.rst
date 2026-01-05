
.. include:: ../../../../Includes.txt

.. _Encrypt-hashNeedsUpdate:

==============================================
Encrypt::hashNeedsUpdate()
==============================================

\\nn\\t3::Encrypt()->hashNeedsUpdate(``$passwordHash = '', $loginType = 'FE'``);
----------------------------------------------

Prüft, ob Hash aktualisiert werden muss, weil er nicht dem aktuellen Verschlüsselungs-Algorithmus enspricht.
Beim Update von Typo3 in eine neue LTS wird gerne auch der Hashing-Algorithmus der Passwörter in der Datenbank
verbessert. Diese Methode prüft, ob der übergebene Hash noch aktuell ist oder aktualisert werden muss.

Gibt ``true`` zurück, falls ein Update erforderlich ist.

.. code-block:: php

	\nn\t3::Encrypt()->hashNeedsUpdate('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');  // true

Ein automatisches Update des Passwortes könnte in einem manuellen FE-User Authentification-Service so aussehen:

.. code-block:: php

	$uid = $user['uid'];  // uid des FE-Users
	$authResult = \nn\t3::Encrypt()->checkPassword( $passwordHashInDatabase, $clearTextPassword );
	if ($authResult & \nn\t3::Encrypt()->hashNeedsUpdate( $passwordHashInDatabase )) {
	    \nn\t3::FrontendUserAuthentication()->setPassword( $uid, $clearTextPassword );
	}

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hashNeedsUpdate( $passwordHash = '', $loginType = 'FE' ) {
   	// Könnte z.B. `TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash` sein
   	$currentHashInstance = $this->getHashInstance( $passwordHash );
   	// Könnte z.B. `TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash` sein
   	$expectedHashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance( $loginType );
   	return get_class($currentHashInstance) != get_class($expectedHashInstance);
   }
   

