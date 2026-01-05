
.. include:: ../../../../Includes.txt

.. _BackendUser-isLoggedIn:

==============================================
BackendUser::isLoggedIn()
==============================================

\\nn\\t3::BackendUser()->isLoggedIn(``$request = NULL``);
----------------------------------------------

Prüft, ob ein BE-User eingeloggt ist.
Beispiel: Im Frontend bestimmte Inhalte nur zeigen, wenn der User im Backend eingeloggt ist.
Früher: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	// Prüfen nach vollständiger Initialisierung des Front/Backends
	\nn\t3::BackendUser()->isLoggedIn();
	
	// Prüfen anhand des JWT, z.B. in einem eID-script vor Authentifizierung
	\nn\t3::BackendUser()->isLoggedIn( $request );

| ``@param ServerRequest $request``
| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isLoggedIn( $request = null )
   {
   	if ($request) {
   		$cookieName = $this->getCookieName();
   		$jwt = $request->getCookieParams()[$cookieName] ?? false;
   		$identifier = false;
   		if ($jwt) {
   			try {
   				$params = $request->getAttribute('normalizedParams') ?? NormalizedParams::createFromRequest($request);
   				$cookieScope = $this->getCookieScope( $params );
   				$identifier = \TYPO3\CMS\Core\Session\UserSession::resolveIdentifierFromJwt($jwt, $cookieScope);
   			} catch( \Exception $e ) {}
   		}
   		if ($identifier) return true;
   	}
   	$context = GeneralUtility::makeInstance(Context::class);
   	return $context->getPropertyFromAspect('backend.user', 'isLoggedIn');
   }
   

