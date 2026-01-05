
.. include:: ../../../../Includes.txt

.. _BackendUser-isLoggedIn:

==============================================
BackendUser::isLoggedIn()
==============================================

\\nn\\t3::BackendUser()->isLoggedIn(``$request = NULL``);
----------------------------------------------

Checks whether a BE user is logged in.
Example: Only show certain content in the frontend if the user is logged in in the backend.
Previously: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	// Check after complete initialization of the front/backend
	\nn\t3::BackendUser()->isLoggedIn();
	
	// Check using the JWT, e.g. in an eID script before authentication
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
   

