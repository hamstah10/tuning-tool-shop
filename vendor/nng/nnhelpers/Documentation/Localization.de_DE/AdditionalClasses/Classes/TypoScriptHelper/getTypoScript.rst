
.. include:: ../../../../Includes.txt

.. _TypoScriptHelper-getTypoScript:

==============================================
TypoScriptHelper::getTypoScript()
==============================================

\\nn\\t3::TypoScriptHelper()->getTypoScript(``$pageUid = NULL``);
----------------------------------------------

Get complete TypoScript setup for a given page ID following TYPO3 13 approach.

.. code-block:: php

	$typoScriptHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
	
	// get typoscript for current page
	$typoScriptHelper->getTypoScript();
	
	// get typoscript for page with uid 1
	$typoScriptHelper->getTypoScript( 1 );
	

| ``@param int $pageUid`` Page UID to get TypoScript for
| ``@return array Complete TypoScript setup with dot-syntax``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTypoScript(?int $pageUid = null): array
   {
   	$ts = $this->getTypoScriptObject($pageUid);
   	$settings = [];
   	if ($ts->hasPage() && $ts->hasSetup()) {
   		$settings = $ts->getSetupTree()->toArray();
   	}
   	return $settings;
   }
   

