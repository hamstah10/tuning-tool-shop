
.. include:: ../../../../Includes.txt

.. _Encrypt-hashNeedsUpdate:

==============================================
Encrypt::hashNeedsUpdate()
==============================================

\\nn\\t3::Encrypt()->hashNeedsUpdate(``$passwordHash = '', $loginType = 'FE'``);
----------------------------------------------

Checks whether the hash needs to be updated because it does not correspond to the current encryption algorithm.
When updating Typo3 to a new LTS, the hashing algorithm of the passwords in the database is also often
is improved. This method checks whether the transferred hash is still up-to-date or needs to be updated.

Returns ``true`` if an update is required.

.. code-block:: php

	\nn\t3::Encrypt()->hashNeedsUpdate('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.'); // true

An automatic update of the password could look like this in a manual FE user authentication service:

.. code-block:: php

	$uid = $user['uid']; // uid of the FE user
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
   

