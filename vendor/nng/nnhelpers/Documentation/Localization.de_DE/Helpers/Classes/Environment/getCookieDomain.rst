
.. include:: ../../../../Includes.txt

.. _Environment-getCookieDomain:

==============================================
Environment::getCookieDomain()
==============================================

\\nn\\t3::Environment()->getCookieDomain(``$loginType = 'FE'``);
----------------------------------------------

Die Cookie-Domain holen z.B. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getCookieDomain()

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCookieDomain ( $loginType = 'FE' ) {
   	$cookieDomain = $this->getLocalConf( $loginType . '.cookieDomain' )
   		?: $this->getLocalConf( 'SYS.cookieDomain' );
   	if (!$cookieDomain) {
   		return '';
   	}
   	// Check if cookieDomain is a regex pattern (starts and ends with /)
   	if ($cookieDomain[0] === '/') {
   		$host = GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY');
   		if (@preg_match($cookieDomain, $host, $match)) {
   			$cookieDomain = $match[0];
   		} else {
   			$cookieDomain = '';
   		}
   	}
   	return $cookieDomain;
   }
   

