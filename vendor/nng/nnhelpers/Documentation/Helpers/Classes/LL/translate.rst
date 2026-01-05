
.. include:: ../../../../Includes.txt

.. _LL-translate:

==============================================
LL::translate()
==============================================

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE', $apiKey = NULL``);
----------------------------------------------

Translates a text via DeepL.
An API key must be entered in the Extension Manager.
DeepL allows the translation of up to 500,000 characters / month free of charge.

.. code-block:: php

	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 1 );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN', 'DE' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 1, 0 );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN', 'DE', $apiKey );

| ``@param string $srcText`` Text to be translated
| ``@param string|int $targetLanguageKey`` Target language (e.g. 'EN' or '1')
| ``@param string|int $sourceLanguageKey`` Source language (e.g. 'DE' or '0')
| ``@param string $apiKey`` DeepL Api key (if not defined in the ExtensionManager)
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function translate( $srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE', $apiKey = null )
   {
   	$deeplConfig = \nn\t3::Environment()->getExtConf('nnhelpers');
   	if (!$apiKey) {
   		$apiKey = $deeplConfig['deeplApiKey'] ?? false;
   	}
   	if (!$this->sysLanguages) {
   		$this->sysLanguages = \nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');
   	}
   	// convert numeric language_uid to language string
   	if (is_numeric($targetLanguageKey)) {
   		$targetLanguageKey = $this->sysLanguages[$targetLanguageKey];
   	}
   	if (is_numeric($sourceLanguageKey)) {
   		$sourceLanguageKey = $this->sysLanguages[$sourceLanguageKey];
   	}
   	if (!$apiKey || !$deeplConfig['deeplApiUrl']) {
   		return 'Bitte API Key und URL für DeepL im Extension-Manager angeben';
   	}
   	$srcText = \nn\t3::Convert($srcText)->toUTF8();
   	$params = [
   		'text'			=> '<LL>' . $srcText . '</LL>',
   		'source_lang'	=> strtoupper($sourceLanguageKey),
   		'target_lang'	=> strtoupper($targetLanguageKey),
   		'tag_handling'	=> 'xml',
   	];
   	$headers = [
   		'Authorization' => 'DeepL-Auth-Key ' . $apiKey,
   	];
   	$result = \nn\t3::Request()->POST( $deeplConfig['deeplApiUrl'], $params, $headers );
   	if ($result['status'] != 200) {
   		die('[ERROR] Fehler bei POST-Query an ' . $deeplConfig['deeplApiUrl'] . ' [' . $result['status'] . '] ' . $result['content']);
   		return "[ERROR] Fehler bei POST-Query an {$deeplConfig['deeplApiUrl']} [{$result['status']}, {$result['error']}]";
   	}
   	$json = json_decode( $result['content'], true ) ?: ['error' => 'JSON leer'];
   	if (!$json || !isset($json['translations'][0]['text'])) {
   		return "[ERROR] Fehler bei Übersetzung. Kein Text von DeepL zurückgegeben oder JSON konnte nicht geparsed werden.";
   	}
   	$text = $json['translations'][0]['text'] ?? '';
   	$text = trim(str_replace(['<LL>', '</LL>'], '', $text));
   	$text = str_replace( ">.\n", ">\n", $text);
   	return $text;
   }
   

