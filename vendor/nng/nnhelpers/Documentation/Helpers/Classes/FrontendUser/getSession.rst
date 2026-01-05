
.. include:: ../../../../Includes.txt

.. _FrontendUser-getSession:

==============================================
FrontendUser::getSession()
==============================================

\\nn\\t3::FrontendUser()->getSession();
----------------------------------------------

Get the current user session.

.. code-block:: php

	\nn\t3::FrontendUser()->getSession();

| ``@return \TYPO3\CMS\Core\Session\UserSession``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSession()
   {
   	if ($session = $this->userSession) return $session;
   	$user = $this->getFrontendUser();
   	if ($user) {
   		return $user->getSession();
   	}
   	$userSessionManager = UserSessionManager::create('FE');
   	$session = $userSessionManager->createFromRequestOrAnonymous($GLOBALS['TYPO3_REQUEST'], $this->getCookieName());
   	return $this->userSession = $session;
   }
   

