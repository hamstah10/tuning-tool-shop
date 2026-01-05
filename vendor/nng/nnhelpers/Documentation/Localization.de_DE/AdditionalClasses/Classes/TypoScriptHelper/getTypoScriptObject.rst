
.. include:: ../../../../Includes.txt

.. _TypoScriptHelper-getTypoScriptObject:

==============================================
TypoScriptHelper::getTypoScriptObject()
==============================================

\\nn\\t3::TypoScriptHelper()->getTypoScriptObject(``$pageUid = NULL``);
----------------------------------------------

Get the TypoScript setup as TypoScript object.

| ``@param int $pageUid`` Page UID to get TypoScript for
| ``@return \TYPO3\CMS\Core\TypoScript\FrontendTypoScript``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTypoScriptObject(?int $pageUid = null): FrontendTypoScript
   {
   	if (!$pageUid) {
   		$pageUid = \nn\t3::Page()->getPid();
   	}
   	// make sure, we don't get config from disabled TS templates in BE context
   	$context = GeneralUtility::makeInstance(Context::class);
   	$visibilityAspect = GeneralUtility::makeInstance(VisibilityAspect::class);
   	$context->setAspect('visibility', $visibilityAspect);
   	$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
   	if (!$site) {
   		throw new \Exception('Site not found for page ID ' . $pageUid);
   	}
   	$pageInformation = $this->getPageInformation($site, $pageUid);
   	$isCachingAllowed = false;
   	$conditionMatcherVariables = $this->prepareConditionMatcherVariables($site, $pageInformation);
   	$frontendTypoScript = $this->frontendTypoScriptFactory->createSettingsAndSetupConditions(
   		$site,
   		$pageInformation->getSysTemplateRows(),
   		$conditionMatcherVariables,
   		$isCachingAllowed ? $this->typoScriptCache : null,
   	);
   	$ts = $this->frontendTypoScriptFactory->createSetupConfigOrFullSetup(
   		true,  // $needsFullSetup -> USER_INT
   		$frontendTypoScript,
   		$site,
   		$pageInformation->getSysTemplateRows(),
   		$conditionMatcherVariables,
   		'0',  // $type -> typeNum (default: 0; GET/POST param: type)
   		$isCachingAllowed ? $this->typoScriptCache : null,
   		null,  // $request
   	);
   	return $ts;
   }
   

