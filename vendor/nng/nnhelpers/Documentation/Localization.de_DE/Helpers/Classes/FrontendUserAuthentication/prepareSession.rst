
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-prepareSession:

==============================================
FrontendUserAuthentication::prepareSession()
==============================================

\\nn\\t3::FrontendUserAuthentication()->prepareSession(``$usernameOrUid = NULL, $unhashedSessionId = NULL``);
----------------------------------------------

Eine neue FrontenUser-Session in der Tabelle ``fe_sessions`` anlegen.
Es kann wahlweise die ``fe_users.uid`` oder der ``fe_users.username`` übergeben werden.

Der User wird dabei nicht automatisch eingeloggt. Stattdessen wird nur eine gültige Session
in der Datenbank angelegt und vorbereitet, die Typo3 später zur Authentifizierung verwenden kann.

Gibt die Session-ID zurück.

Die Session-ID entspricht hierbei exakt dem Wert im ``fe_typo_user``-Cookie - aber nicht zwingend dem
Wert, der in ``fe_sessions.ses_id`` gespeichert wird. Der Wert in der Datenbank wird ab TYPO3 v11
gehashed.

.. code-block:: php

	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 1 );
	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 'david' );
	
	$hashInDatabase = \nn\t3::Encrypt()->hashSessionId( $sessionId );

Falls die Session mit einer existierenden SessionId erneut aufgebaut werden soll, kann als optionaler,
zweiter Parameter eine (nicht-gehashte) SessionId übergeben werden:

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
   

