
.. include:: ../../../../Includes.txt

.. _Encrypt-hashSessionId:

==============================================
Encrypt::hashSessionId()
==============================================

\\nn\\t3::Encrypt()->hashSessionId(``$sessionId = NULL``);
----------------------------------------------

Session-Hash für ``fe_sessions.ses_id`` holen.
Enspricht dem Wert, der für den Cookie ``fe_typo_user`` in der Datenbank gespeichert wird.

In TYPO3 < v10 wird hier ein unveränderter Wert zurückgegeben. Ab TYPO3 v10 wird die Session-ID im
Cookie ``fe_typo_user`` nicht mehr direkt in der Datenbank gespeichert, sondern gehashed.
Siehe: ``TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend->hash()``.

.. code-block:: php

	\nn\t3::Encrypt()->hashSessionId( $sessionIdFromCookie );

Beispiel:

.. code-block:: php

	$cookie = $_COOKIE['fe_typo_user'];
	$hash = \nn\t3::Encrypt()->hashSessionId( $cookie );
	$sessionFromDatabase = \nn\t3::Db()->findOneByValues('fe_sessions', ['ses_id'=>$hash]);

Wird unter anderen verwendet von: ``\nn\t3::FrontendUserAuthentication()->loginBySessionId()``.

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hashSessionId( $sessionId = null ) {
   	$key = sha1(($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] ?? '') . 'core-session-backend');
   	return hash_hmac('sha256', $sessionId, $key);
   }
   

