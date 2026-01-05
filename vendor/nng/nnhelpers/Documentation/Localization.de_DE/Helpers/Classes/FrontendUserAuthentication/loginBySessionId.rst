
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-loginBySessionId:

==============================================
FrontendUserAuthentication::loginBySessionId()
==============================================

\\nn\\t3::FrontendUserAuthentication()->loginBySessionId(``$sessionId = ''``);
----------------------------------------------

Login eines FE-Users anhand einer Session-ID.

Die Session-ID entspricht dem TYPO3 Cookie ``fe_typo_user``. In der Regel gibt es für
jede Fe-User-Session einen Eintrag in der Tabelle ``fe_sessions``. Bis zu Typo3 v10 entsprach
die Spalte ``ses_id`` exakt dem Cookie-Wert.

Ab Typo3 v10 wird der Wert zusätzlich gehashed.

Siehe auch ``\nn\t3::Encrypt()->hashSessionId( $sessionId );``

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginBySessionId( $sessionId );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function loginBySessionId( $sessionId = '' )
   {
   	if (!trim($sessionId)) return [];
   	$sessionId = \nn\t3::Encrypt()->hashSessionId( $sessionId );
   	$session = \nn\t3::Db()->findOneByValues( 'fe_sessions', ['ses_id'=>$sessionId] );
   	if (!$session) return [];
   	if ($feUserUid = $session['ses_userid']) {
   		return $this->loginUid( $feUserUid );
   	}
   	return [];
   }
   

