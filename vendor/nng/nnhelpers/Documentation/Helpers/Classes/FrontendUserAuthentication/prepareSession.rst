
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-prepareSession:

==============================================
FrontendUserAuthentication::prepareSession()
==============================================

\\nn\\t3::FrontendUserAuthentication()->prepareSession(``$usernameOrUid = NULL, $unhashedSessionId = NULL``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function prepareSession( $usernameOrUid = null, $unhashedSessionId = null )
   {
   	if (!$usernameOrUid) return null;
   	if ($uid = intval($usernameOrUid)) {
   		$user = \nn\t3::Db()->findByUid('fe_users', $uid);
   	} else {
   		$user = \nn\t3::Db()->findOneByValues('fe_users', ['username'=>$usernameOrUid]);
   	}
   	if (!$user) return null;
   	if (!$unhashedSessionId) {
   		$unhashedSessionId = $this->createSessionId();
   	}
   	$hashedSessionId = \nn\t3::Encrypt()->hashSessionId( $unhashedSessionId );
   	$existingSession = \nn\t3::Db()->findOneByValues('fe_sessions', ['ses_id'=>$hashedSessionId]);
   	if (!$existingSession) {
   		$this->id = $hashedSessionId;
   		$record = $this->elevateToFixatedUserSession($unhashedSessionId, $user['uid']);
   		\nn\t3::Db()->insert('fe_sessions', $record);
   	} else {
   		\nn\t3::Db()->update('fe_sessions', ['ses_tstamp'=>$GLOBALS['EXEC_TIME']], ['ses_id'=>$hashedSessionId]);
   	}
   	$request = \nn\t3::Environment()->getRequest();
   	$this->start( $request );
   	return $unhashedSessionId;
   }
   

