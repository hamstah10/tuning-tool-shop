
.. include:: ../../../../Includes.txt

.. _FrontendUser-logout:

==============================================
FrontendUser::logout()
==============================================

\\nn\\t3::FrontendUser()->logout();
----------------------------------------------

Log out the current FE-USer manually

.. code-block:: php

	\nn\t3::FrontendUser()->logout();

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function logout()
   {
   	if (!$this->isLoggedIn()) return false;
   	// In der MiddleWare ist der FE-User evtl. noch nicht initialisiert...
   	if ($TSFE = \nn\t3::Tsfe()->get()) {
   		if (($TSFE->fe_user ?? null) && method_exists($TSFE->fe_user, 'logoff')) {
   			$TSFE->fe_user->logoff();
   		}
   	}
   	// Session-Daten aus Tabelle `fe_sessions` löschen
   	if ($sessionManager = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Session\SessionManager::class)) {
   		$sessionBackend = $sessionManager->getSessionBackend('FE');
   		if ($sessionId = $this->getSessionId()) {
   			$sessionBackend->remove( $sessionId );
   		}
   	}
   	// ... aber Cookie löschen geht immer!
   	$this->removeCookie();
   	// ToDo: Replace with Signal/Slot when deprecated
   	if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed'] ?? false) {
   		$_params = array();
   		foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed'] as $_funcRef) {
   			if ($_funcRef) GeneralUtility::callUserFunction($_funcRef, $_params, $this);
   		}
   	}
   }
   

