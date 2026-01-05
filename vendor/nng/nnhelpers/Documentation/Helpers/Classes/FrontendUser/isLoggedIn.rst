
.. include:: ../../../../Includes.txt

.. _FrontendUser-isLoggedIn:

==============================================
FrontendUser::isLoggedIn()
==============================================

\\nn\\t3::FrontendUser()->isLoggedIn(``$request = NULL``);
----------------------------------------------

Checks whether the user is currently logged in as a FE user.
Earlier: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser

.. code-block:: php

	// Check after complete initialization of the front/backend
	\nn\t3::FrontendUser()->isLoggedIn();
	
	// Check using the JWT, e.g. in an eID script before authentication
	\nn\t3::FrontendUser()->isLoggedIn( $request );

| ``@param ServerRequest $request``
| ``@return boolean``

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
   	$user = $this->getFrontendUser();
   	// Context `frontend.user.isLoggedIn` scheint in Middleware nicht zu gehen. Fallback auf TSFE.
   	$loginUserFromTsfe = $user && isset($user->user['uid']);
   	$context = GeneralUtility::makeInstance(Context::class);
   	return $context->getPropertyFromAspect('frontend.user', 'isLoggedIn') || $loginUserFromTsfe;
   }
   

