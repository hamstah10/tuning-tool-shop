
.. include:: ../../../../Includes.txt

.. _Content-localize:

==============================================
Content::localize()
==============================================

\\nn\\t3::Content()->localize(``$table = 'tt_content', $data = [], $localize = true``);
----------------------------------------------

Daten lokalisieren / übersetzen.

Beispiele:

Daten übersetzen, dabei die aktuelle Sprache des Frontends verwenden.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data );

Daten in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, 2 );

Daten mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain,
die in der Site-Config definiert wurde.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );

| ``@param string $table`` Datenbank-Tabelle
| ``@param array $data`` Array mit den Daten der Standard-Sprache (languageUid = 0)
| ``@param mixed $localize`` Angabe, wie übersetzt werden soll. Boolean, uid oder Array mit uids
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
   

