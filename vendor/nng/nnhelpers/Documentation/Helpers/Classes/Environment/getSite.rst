
.. include:: ../../../../Includes.txt

.. _Environment-getSite:

==============================================
Environment::getSite()
==============================================

\\nn\\t3::Environment()->getSite(``$request = NULL``);
----------------------------------------------

Get the current ``site`` object.
This object can be used to access the configuration from the site YAML file from TYPO3 9 onwards, for example.

In the context of a MiddleWare, the ``site`` may not yet be parsed / loaded.
In this case, the ``$request`` from the MiddleWare can be passed to determine the site.

See also ``\nn\t3::Settings()->getSiteConfig()`` to read the site configuration.

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
   

