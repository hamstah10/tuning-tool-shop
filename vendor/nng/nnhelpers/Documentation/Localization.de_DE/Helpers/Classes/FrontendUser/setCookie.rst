
.. include:: ../../../../Includes.txt

.. _FrontendUser-setCookie:

==============================================
FrontendUser::setCookie()
==============================================

\\nn\\t3::FrontendUser()->setCookie(``$sessionId = NULL, $request = NULL``);
----------------------------------------------

Den ``fe_typo_user``-Cookie manuell setzen.

Wird keine ``sessionID`` übergeben, sucht Typo3 selbst nach der Session-ID des FE-Users.

Bei Aufruf dieser Methode aus einer MiddleWare sollte der ``Request`` mit übergeben werden.
Dadurch kann z.B. der globale ``$_COOKIE``-Wert und der ``cookieParams.fe_typo_user`` im Request
vor Authentifizierung über ``typo3/cms-frontend/authentication`` in einer eigenen MiddleWare
gesetzt werden. Hilfreich, falls eine Crossdomain-Authentifizierung erforderlich ist (z.B.
per Json Web Token / JWT).

.. code-block:: php

	\nn\t3::FrontendUser()->setCookie();
	\nn\t3::FrontendUser()->setCookie( $sessionId );
	\nn\t3::FrontendUser()->setCookie( $sessionId, $request );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setCookie( $sessionId = null, &$request = null )
   {
   	if (!$sessionId) {
   		$sessionId = $this->getSessionId();
   	}
   	$jwt = self::encodeHashSignedJwt(
   		[
   			'identifier' => $sessionId,
   			'time' => (new \DateTimeImmutable())->format(\DateTimeImmutable::RFC3339),
   		],
   		self::createSigningKeyFromEncryptionKey(UserSession::class)
   	);
   	$cookieName = $this->getCookieName();
   	$_COOKIE[$cookieName] = $jwt;
   	\nn\t3::Cookies()->add( $cookieName, $jwt );
   }
   

