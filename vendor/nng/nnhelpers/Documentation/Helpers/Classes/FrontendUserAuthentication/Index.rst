
.. include:: ../../../Includes.txt

.. _FrontendUserAuthentication:

==============================================
FrontendUserAuthentication
==============================================

\\nn\\t3::FrontendUserAuthentication()
----------------------------------------------

Front-end user methods: From logging in to changing passwords

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUserAuthentication()->login(``$username = '', $password = '', $startFeUserSession = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of an FE user using the user name and password

.. code-block:: php

	// Check credentials and start feUser session
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	
	// Check only, do not establish a feUser session
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password', false );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUserAuthentication::login() <FrontendUserAuthentication-login>`

\\nn\\t3::FrontendUserAuthentication()->loginBySessionId(``$sessionId = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of an FE user using a session ID.

The session ID corresponds to the TYPO3 cookie ``fe_typo_user``. As a rule, there is one entry for
one entry in the ``fe_sessions`` table for each FE user session. Up to Typo3 v10, the
the ``ses_id`` column corresponded exactly to the cookie value.

As of Typo3 v10, the value is also hashed.

See also ``\nn\t3::Encrypt()->hashSessionId( $sessionId );``

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginBySessionId( $sessionId );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUserAuthentication::loginBySessionId() <FrontendUserAuthentication-loginBySessionId>`

\\nn\\t3::FrontendUserAuthentication()->loginByUsername(``$username = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of an FE user based on the user name

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginByUsername( '99grad' );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUserAuthentication::loginByUsername() <FrontendUserAuthentication-loginByUsername>`

\\nn\\t3::FrontendUserAuthentication()->loginField(``$value = NULL, $fieldName = 'uid'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of an FE user using any field.
No password required.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginField( $value, $fieldName );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUserAuthentication::loginField() <FrontendUserAuthentication-loginField>`

\\nn\\t3::FrontendUserAuthentication()->loginUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of an FE user using an fe_user.uid

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginUid( 1 );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUserAuthentication::loginUid() <FrontendUserAuthentication-loginUid>`

\\nn\\t3::FrontendUserAuthentication()->prepareSession(``$usernameOrUid = NULL, $unhashedSessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a new frontend user session in the ``fe_sessions`` table.
Either the ``fe_users.uid`` or the ``fe_users.username`` can be transferred.

The user is not automatically logged in. Instead, only a valid session
is created and prepared in the database, which Typo3 can later use for authentication.

Returns the session ID.

The session ID corresponds exactly to the value in the ``fe_typo_user cookie``- but not necessarily the
value that is stored in ``fe_sessions.ses_id``. The value in the database is hashed from TYPO3 v11
hashed.

.. code-block:: php

	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 1 );
	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 'david' );
	
	$hashInDatabase = \nn\t3::Encrypt()->hashSessionId( $sessionId );

If the session is to be re-established with an existing SessionId, a (non-hashed) second parameter can be used as an optional,
second parameter, a (non-hashed) SessionId can be passed:

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, 'meincookiewert' );
	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, $_COOKIE['fe_typo_user'] );

| ``@return string``

| :ref:`➜ Go to source code of FrontendUserAuthentication::prepareSession() <FrontendUserAuthentication-prepareSession>`

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change the password of an FE user.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Password#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Password#$' );

| ``@return boolean``

| :ref:`➜ Go to source code of FrontendUserAuthentication::setPassword() <FrontendUserAuthentication-setPassword>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
