
.. include:: ../../../../Includes.txt

.. _Encrypt-checkPassword:

==============================================
Encrypt::checkPassword()
==============================================

\\nn\\t3::Encrypt()->checkPassword(``$password = '', $passwordHash = NULL``);
----------------------------------------------

Prüft, ob Hash eines Passwortes und ein Passwort übereinstimmen.
Anwendung: Passwort-Hash eines fe_users in der Datenbank mit übergebenem Passwort
vergleichen.

.. code-block:: php

	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function checkPassword ( $password = '', $passwordHash = null )
   {
   	if ($passwordHash === null || $passwordHash === '') {
   		return false;
   	}
   	// siehe localConfiguration.php [FE][passwordHashing][className], default für Typo3 9 ist \TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash
   	$hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('FE');
   	$result = $hashInstance->checkPassword($password, $passwordHash);
   	if ($result) return true;
   	// Fallback für Passworte, die nach Update auf Typo3 9 noch den md5-Hash oder andere verwenden
   	if ($hashInstance = $this->getHashInstance( $passwordHash )) {
   		$result = $hashInstance->checkPassword($password, $passwordHash);
   		return $result;
   	}
   	return false;
   }
   

