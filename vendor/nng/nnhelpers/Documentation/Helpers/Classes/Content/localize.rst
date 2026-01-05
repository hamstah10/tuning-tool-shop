
.. include:: ../../../../Includes.txt

.. _Content-localize:

==============================================
Content::localize()
==============================================

\\nn\\t3::Content()->localize(``$table = 'tt_content', $data = [], $localize = true``);
----------------------------------------------

Localize / translate data.

Examples:

Translate data using the current language of the frontend.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data );

Get data in a DIFFERENT language than the one set in the frontend.
Takes into account the fallback chain of the language that was set in the site config

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, 2 );

Get data with own fallback chain. Completely ignores the chain,
that was defined in the site config.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );

| ``@param string $table`` Database table
| ``@param array $data`` Array with the data of the default language (languageUid = 0)
| ``@param mixed $localize`` Specification of how to translate. Boolean, uid or array with uids
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function localize($table = 'tt_content', $data = [], $localize = true)
   {
   	// Irgendwas ging schief?
   	$pageRepository = \nn\t3::injectClass(PageRepository::class);
   	if (!$pageRepository) return $data;
   	// Aktuelle Sprache aus dem Frontend-Request
   	$currentLanguageUid = \nn\t3::Environment()->getLanguage();
   	// `false` angegeben - oder Zielsprache ist Standardsprache? Dann nichts tun.
   	if ($localize === false || $localize === $currentLanguageUid) {
   		return $data;
   	}
   	// `true` angegeben: Dann ist die Zielsprache == die aktuelle Sprache im FE
   	if ($localize === true) {
   		$localize = $currentLanguageUid;
   		$fallbackChain = \nn\t3::Environment()->getLanguageFallbackChain($localize);
   		$languageId = $localize;
   	}
   	// `uid` der Zielsprache angegeben (z.B. `1`)? Dann Fallback-Chain aus TYPO3-Site-Konfiguration laden
   	if (is_numeric($localize)) {
   		$languageId = (int)$localize;
   		$fallbackChain = \nn\t3::Environment()->getLanguageFallbackChain($localize);
   	}
   	// `[2,1,0]` als Zielsprachen angegeben? Dann als Fallback-Chain verwenden
   	if (is_array($localize)) {
   		$languageId = $localize[0] ?? 0;
   		$fallbackChain = $localize;
   	}
   	$overlayType = LanguageAspect::OVERLAYS_ON;
   	foreach ($fallbackChain as $langUid) {
   		$langAspect = GeneralUtility::makeInstance(LanguageAspect::class, $langUid, $langUid, $overlayType, $fallbackChain);
   		if ($overlay = $pageRepository->getLanguageOverlay($table, $data, $langAspect)) {
   			return $overlay;
   		}
   	}
   	return $data;
   }
   

