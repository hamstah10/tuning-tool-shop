
.. include:: ../../../../Includes.txt

.. _FrontendUser-setCookie:

==============================================
FrontendUser::setCookie()
==============================================

\\nn\\t3::FrontendUser()->setCookie(``$sessionId = NULL, $request = NULL``);
----------------------------------------------

Set the ``fe_typo_user cookie`` manually.

If no ``sessionID`` is passed, Typo3 searches for the FE user's session ID itself.

When calling this method from a MiddleWare, the ``request`` should be passed with .
This allows, for example, the global ``$_COOKIE value`` and the ``cookieParams.fe_typo_user`` in the request
before authentication via ``typo3/cms-frontend/authentication`` in a separate MiddleWare
must be set. Helpful if cross-domain authentication is required (e.g.
via Json Web Token / JWT).

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
   

