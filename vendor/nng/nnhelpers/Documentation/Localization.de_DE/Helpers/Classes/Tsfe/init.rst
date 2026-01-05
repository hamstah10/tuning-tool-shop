
.. include:: ../../../../Includes.txt

.. _Tsfe-init:

==============================================
Tsfe::init()
==============================================

\\nn\\t3::Tsfe()->init(``$pid = 0, $typeNum = 0``);
----------------------------------------------

Das ``$GLOBALS['TSFE']`` initialisieren.
Dient nur zur Kompatibilität mit älterem Code, das noch ``$GLOBALS['TSFE']`` verwendet.

.. code-block:: php

	// TypoScript holen auf die 'alte' Art
	$pid = \nn\t3::Page()->getPid();
	\nn\t3::Tsfe()->init($pid);
	$setup = $GLOBALS['TSFE']->tmpl->setup;

| ``@param int $pid``
| ``@param int $typeNum``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function init($pid = 0, $typeNum = 0)
   {
   	if (isset($GLOBALS['TSFE'])) {
   		return;
   	}
   	$request = \nn\t3::Environment()->getRequest();
   	if (!$request) {
   		return;
   	}
   	
   	$cObj = $this->cObj( $request );
   	$tsfe = $request->getAttribute('frontend.controller');
   	if (!$tsfe) {
   		return;
   	}
   	
   	$tsfe->cObj = $cObj;
   	$fts = $request->getAttribute('frontend.typoscript');
   	if ($fts) {
   		$tmpl = new stdClass();
   		$tmpl->setup  = $fts->getSetupArray();
   		$tmpl->config = $fts->getConfigArray();
   		$tsfe->tmpl = $tmpl;
   	}
   	$pageRepository = GeneralUtility::makeInstance(PageRepository::class);
   	$tsfe->sys_page = $pageRepository;
   	$userSessionManager = \TYPO3\CMS\Core\Session\UserSessionManager::create('FE');
   	$userSession = $userSessionManager->createAnonymousSession();
   	$tsfe->fe_user = $userSession;
   	$GLOBALS['TSFE'] = $tsfe;
   }
   

