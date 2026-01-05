
.. include:: ../../../../Includes.txt

.. _Environment-setLanguage:

==============================================
Environment::setLanguage()
==============================================

\\nn\\t3::Environment()->setLanguage(``$languageId = 0``);
----------------------------------------------

Set the current language.

Helpful if we need the language in a context where it has not been initialized, e.g. in a
initialized, e.g. in a MiddleWare or CLI.

.. code-block:: php

	\nn\t3::Environment()->setLanguage(0);

| ``@param int $languageId``
| ``@return self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setLanguage ( $languageId = 0 )
   {
   	$site = $this->getSite();
   	try {
   		$language = $site->getLanguageById( $languageId );
   	} catch (\Exception $e) {
   		$language = $site->getDefaultLanguage();
   	}
   	$languageAspect = LanguageAspectFactory::createFromSiteLanguage($language);
   	$context = GeneralUtility::makeInstance(Context::class);
   	$context->setAspect('language', $languageAspect);
   	// keep the TYPO3_REQUEST in sync with the new language in case other extensions are relying on it
   	if ($GLOBALS['TYPO3_REQUEST'] ?? false) {
   		$GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']->withAttribute('language', $language);
   	}
   	// Initialize LanguageService for this language (needed for BackendUtility etc.)
   	$languageServiceFactory = GeneralUtility::makeInstance(LanguageServiceFactory::class);
   	$GLOBALS['LANG'] = $languageServiceFactory->createFromSiteLanguage($language);
   	return $this;
   }
   

