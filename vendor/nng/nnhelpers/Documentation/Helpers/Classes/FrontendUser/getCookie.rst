
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCookie:

==============================================
FrontendUser::getCookie()
==============================================

\\nn\\t3::FrontendUser()->getCookie();
----------------------------------------------

Gets the current ``fe_typo_user`` cookie.

.. code-block:: php

	$cookie = \nn\t3::FrontendUser()->getCookie();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCookie()
   {
   	$cookieName = $this->getCookieName();
   	if ($request = &$GLOBALS['TYPO3_REQUEST']) {
   		$cookieParams = $request->getCookieParams();
   		if ($value = $cookieParams[$cookieName] ?? false) {
   			return $value;
   		}
   	}
   	if ($cookie = $_COOKIE[$cookieName] ?? false) {
   		return $cookie;
   	}
   	if ($cookies = \nn\t3::Cookies()->getAll()) {
   		return $cookies[$cookieName]['value'] ?? '';
   	}
   	return '';
   }
   

