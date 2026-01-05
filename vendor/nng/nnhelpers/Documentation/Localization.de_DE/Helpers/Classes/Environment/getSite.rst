
.. include:: ../../../../Includes.txt

.. _Environment-getSite:

==============================================
Environment::getSite()
==============================================

\\nn\\t3::Environment()->getSite(``$request = NULL``);
----------------------------------------------

Das aktuelle ``Site`` Object holen.
Über dieses Object kann z.B. ab TYPO3 9 auf die Konfiguration aus der site YAML-Datei zugegriffen werden.

Im Kontext einer MiddleWare ist evtl. die ``site`` noch nicht geparsed / geladen.
In diesem Fall kann der ``$request`` aus der MiddleWare übergeben werden, um die Site zu ermitteln.

Siehe auch ``\nn\t3::Settings()->getSiteConfig()``, um die site-Konfiguration auszulesen.

.. code-block:: php

	\nn\t3::Environment()->getSite();
	\nn\t3::Environment()->getSite( $request );
	
	\nn\t3::Environment()->getSite()->getConfiguration();
	\nn\t3::Environment()->getSite()->getIdentifier();

| ``@return \TYPO3\CMS\Core\Site\Entity\Site``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSite ( $request = null )
   {
   	if (!$request && !\TYPO3\CMS\Core\Core\Environment::isCli()) {
   		$request = $this->getRequest();
   	}
   	// no request set? try getting site by the current pid
   	if (!$request) {
   		try {
   			$pageUid = \nn\t3::Page()->getPid();
   			$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
   			return $site;
   		} catch ( \Exception $e ) {
   			return null;
   		}
   	};
   	// try getting site by baseURL
   	$site = $request->getAttribute('site');
   	if (!$site || is_a($site, \TYPO3\CMS\Core\Site\Entity\NullSite::class)) {
   		$matcher = GeneralUtility::makeInstance( SiteMatcher::class );
   		$routeResult = $matcher->matchRequest($request);
   		$site = $routeResult->getSite();
   	}
   	// last resort: Just get the first site
   	if (!$site || is_a($site, \TYPO3\CMS\Core\Site\Entity\NullSite::class)) {
   		$siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
   		$sites = $siteFinder->getAllSites();
   		$site = reset($sites) ?: null;
   	}
   	return $site;
   }
   

