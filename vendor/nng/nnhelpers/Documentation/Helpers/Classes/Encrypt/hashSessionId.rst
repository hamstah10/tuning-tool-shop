
.. include:: ../../../../Includes.txt

.. _Encrypt-hashSessionId:

==============================================
Encrypt::hashSessionId()
==============================================

\\nn\\t3::Encrypt()->hashSessionId(``$sessionId = NULL``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hashSessionId( $sessionId = null ) {
   	$key = sha1(($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] ?? '') . 'core-session-backend');
   	return hash_hmac('sha256', $sessionId, $key);
   }
   

