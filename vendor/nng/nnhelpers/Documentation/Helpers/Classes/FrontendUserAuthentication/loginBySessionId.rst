
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-loginBySessionId:

==============================================
FrontendUserAuthentication::loginBySessionId()
==============================================

\\nn\\t3::FrontendUserAuthentication()->loginBySessionId(``$sessionId = ''``);
----------------------------------------------

Login of an FE user using a session ID.

The session ID corresponds to the TYPO3 cookie ``fe_typo_user``. As a rule, there is one entry for
one entry in the ``fe_sessions`` table for each FE user session. Up to Typo3 v10, the
the ``ses_id`` column corresponded exactly to the cookie value.

As of Typo3 v10, the value is also hashed.

See also ``\nn\t3::Encrypt()->hashSessionId( $sessionId );``

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
   

