
.. include:: ../../../../Includes.txt

.. _TranslationHelper-translate:

==============================================
TranslationHelper::translate()
==============================================

\\nn\\t3::TranslationHelper()->translate(``$key, $text = ''``);
----------------------------------------------

[Translate to EN] Übersetzen eines Textes.

.. code-block:: php

	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	$translationHelper->setEnableApi( true );
	$translationHelper->setTargetLanguage( 'EN' );
	$text = $translationHelper->translate('my.example.key', 'Das ist der Text, der übersetzt werden soll');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function translate( $key, $text = '' ) {
   	$keyHash = $this->createKeyHash( $key );
   	$textHash = $this->createTextHash( $text );
   	$l18nData = $this->loadL18nData();
   	$translation = $l18nData[$keyHash] ?? ['_cs'=>false];
   	$textChanged = $translation['_cs'] != $textHash;
   	$autoTranslateEnabled = $this->enableApi && ($this->maxTranslations == 0 || $this->maxTranslations > $this->numTranslations );
   	// Text wurde übersetzt und hat sich nicht geändert
   	if (!$textChanged) {
   		$str = $translation['text'];
   		$str = str_replace('.</p>.', '.</p>', $str);
   		return $str;
   	}
   	// Text wurde nicht übersetzt und Deep-L Übersetzung ist deaktiviert
   	if (!$autoTranslateEnabled) {
   		if ($translation['_cs'] !== false) {
   			return "[Translation needs {$this->targetLanguage} update] " . $text;
   		}
   		return "[Translate to {$this->targetLanguage}] " . $text;
   	}
   	$this->numTranslations++;
   	echo "Translating via Deep-L: {$this->numTranslations} / {$this->maxTranslations} [$keyHash] " . json_encode($key) . "\n";
   	$result = \nn\t3::LL()->translate( $text, $this->targetLanguage );
   	$l18nData[$keyHash] = [
   		'_cs' => $textHash,
   		'text' => $result,
   	];
   	$this->saveL18nData( $l18nData );
   	return $result;
   }
   

