
.. include:: ../../../Includes.txt

.. _Encrypt:

==============================================
Encrypt
==============================================

\\nn\\t3::Encrypt()
----------------------------------------------

Encrypting and hashing passwords

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Encrypt()->checkPassword(``$password = '', $passwordHash = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the hash of a password and a password match.
Application: Password hash of a fe_user in the database with the submitted password
compare.

.. code-block:: php

	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');

| ``@return boolean``

| :ref:`➜ Go to source code of Encrypt::checkPassword() <Encrypt-checkPassword>`

\\nn\\t3::Encrypt()->createJwtSignature(``$header = [], $payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate a signature for a JWT (Json Web Token).
The signature is later transmitted by the user as part of the token.

.. code-block:: php

	$signature = \nn\t3::Encrypt()->createJwtSignature(['alg'=>'HS256', 'type'=>'JWT'], ['test'=>123]);

| ``@param array $header``
| ``@param array $payload``
| ``@return string``

| :ref:`➜ Go to source code of Encrypt::createJwtSignature() <Encrypt-createJwtSignature>`

\\nn\\t3::Encrypt()->decode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Decrypts a string or an array.
To encrypt the data, ``\nn\t3::Encrypt()->encode()`` can be used.
See ``\nn\t3::Encrypt()->encode()`` for a complete example.

.. code-block:: php

	\nn\t3::Encrypt()->decode( '...' );

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::decode() <Encrypt-decode>`

\\nn\\t3::Encrypt()->encode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Encrypts a string or an array.

In contrast to ``\nn\t3::Encrypt()->hash()``, an encrypted value can be decrypted again using ``\nn\t3::Encrypt()->decode()``
can be decrypted again. This method is therefore not suitable for storing sensitive data such as passwords
in a database. Nevertheless, the level of protection is relatively high, as even identical data encrypted with
encrypted with the same salting key look different.

A salting key is generated for the encryption and stored in the ``nnhelpers`` Extension Manager.
This key is unique for each installation. If it is changed, data that has already been encrypted cannot be
be decrypted again.

.. code-block:: php

	\nn\t3::Encrypt()->encode( 'mySecretSomething' );
	\nn\t3::Encrypt()->encode( ['some'=>'secret'] );

Complete example with encryption and decryption:

.. code-block:: php

	$encryptedResult = \nn\t3::Encrypt()->encode( ['password'=>'mysecretsomething'] );
	echo \nn\t3::Encrypt()->decode( $encryptedResult )['password'];
	
	$encryptedResult = \nn\t3::Encrypt()->encode( 'some_secret_phrase' );
	echo \nn\t3::Encrypt()->decode( $encryptedResult );

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::encode() <Encrypt-encode>`

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the class name of the current hash algorithm of an encrypted password,
e.g. to know at fe_user how the password was encrypted in the DB.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

| :ref:`➜ Go to source code of Encrypt::getHashInstance() <Encrypt-getHashInstance>`

\\nn\\t3::Encrypt()->getSaltingKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves the Enryption / Salting Key from the extension configuration for ``nnhelpers``
If no key has been set in the Extension Manager, it is generated automatically
and saved in the ``LocalConfiguration.php``.

.. code-block:: php

	\nn\t3::Encrypt()->getSaltingKey();

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::getSaltingKey() <Encrypt-getSaltingKey>`

\\nn\\t3::Encrypt()->hash(``$string = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Simple hashing, e.g. when checking a uid against a hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Also exists as a ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::hash() <Encrypt-hash>`

\\nn\\t3::Encrypt()->hashNeedsUpdate(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Encrypt::hashNeedsUpdate() <Encrypt-hashNeedsUpdate>`

\\nn\\t3::Encrypt()->hashSessionId(``$sessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get session hash for ``fe_sessions.ses_id``
Corresponds to the value that is stored for the ``fe_typo_user`` cookie in the database.

In TYPO3 < v10 an unchanged value is returned here. As of TYPO3 v10, the session ID is stored in the
cookie ``fe_typo_user`` is no longer stored directly in the database, but hashed.
See: ``TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend->hash()``.

.. code-block:: php

	\nn\t3::Encrypt()->hashSessionId( $sessionIdFromCookie );

Example:

.. code-block:: php

	$cookie = $_COOKIE['fe_typo_user'];
	$hash = \nn\t3::Encrypt()->hashSessionId( $cookie );
	$sessionFromDatabase = \nn\t3::Db()->findOneByValues('fe_sessions', ['ses_id'=>$hash]);

Used by, among others: ``\nn\t3::FrontendUserAuthentication()->loginBySessionId()``.

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::hashSessionId() <Encrypt-hashSessionId>`

\\nn\\t3::Encrypt()->jwt(``$payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a JWT (Json Web Token), sign it and return it ``base64-encoded``.

Do not forget: A JWT is "forgery-proof" because the signature hash can only be generated with
can only be generated with the correct key/salt - but all data in the JWT can be read by anyone
can be viewed through ``base64_decode()``. A JWT is by no means suitable for storing sensitive data such as
passwords or logins!

.. code-block:: php

	\nn\t3::Encrypt()->jwt(['test'=>123]);

| ``@param array $payload``
| ``@return string``

| :ref:`➜ Go to source code of Encrypt::jwt() <Encrypt-jwt>`

\\nn\\t3::Encrypt()->parseJwt(``$token = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse a JWT (Json Web Token) and check the signature.
If the signature is valid (and therefore the payload has not been manipulated), the
payload is returned. If the signature is invalid, ``FALSE`` is returned.

.. code-block:: php

	\nn\t3::Encrypt()->parseJwt('adhjdf.fsdfkjds.HKdfgfksfdsf');

| ``@param string $token``
| ``@return array|false``

| :ref:`➜ Go to source code of Encrypt::parseJwt() <Encrypt-parseJwt>`

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing a password according to the Typo3 principle.
Application: Overwriting the password of a fe_user in the database

.. code-block:: php

	\nn\t3::Encrypt()->password('99grad');

| ``@return string``

| :ref:`➜ Go to source code of Encrypt::password() <Encrypt-password>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
