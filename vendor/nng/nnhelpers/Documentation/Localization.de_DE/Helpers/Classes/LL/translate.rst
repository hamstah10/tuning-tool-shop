
.. include:: ../../../../Includes.txt

.. _LL-translate:

==============================================
LL::translate()
==============================================

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE', $apiKey = NULL``);
----------------------------------------------

Übersetzt einen Text per DeepL.
Ein API-Key muss im Extension Manager eingetragen werden.
DeepL erlaubt die Übersetzung von bis zu 500.000 Zeichen / Monat kostenfrei.

.. code-block:: php

	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat' );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN' );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 1 );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN', 'DE' );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 1, 0 );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN', 'DE', $apiKey );

| ``@param string $srcText``                    Text der übersetzt werden soll
| ``@param string|int $targetLanguageKey``      Zielsprache (z.B. 'EN' oder '1')
| ``@param string|int $sourceLanguageKey``      Quellsprache (z.B. 'DE' oder '0')
| ``@param string $apiKey``                 DeepL Api-Key (falls nicht im ExtensionManager definiert)
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
   

