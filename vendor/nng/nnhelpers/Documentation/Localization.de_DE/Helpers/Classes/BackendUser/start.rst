
.. include:: ../../../../Includes.txt

.. _BackendUser-start:

==============================================
BackendUser::start()
==============================================

\\nn\\t3::BackendUser()->start();
----------------------------------------------

Starte (faken) Backend-User.
Löst das Problem, das z.B. aus dem Scheduler bestimmte Funktionen
wie ``log()`` nicht möglich sind, wenn kein aktiver BE-User existiert.

.. code-block:: php

	\nn\t3::BackendUser()->start();

| ``@return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function start()
   {
   	if (!($GLOBALS['BE_USER'] ?? null)) {
   		$request = $GLOBALS['TYPO3_REQUEST'] ?? null;
   		if ($request) {
   			// TYPO3 v13: Use BackendUserAuthentication directly
   			$backendUser = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class);
   			$backendUser->start($request);
   			$GLOBALS['BE_USER'] = $backendUser;
   		}
   	}
   	return $GLOBALS['BE_USER'] ?? null;
   }
   

