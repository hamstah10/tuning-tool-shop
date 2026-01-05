
.. include:: ../../../../Includes.txt

.. _Environment-getLanguages:

==============================================
Environment::getLanguages()
==============================================

\\nn\\t3::Environment()->getLanguages(``$key = 'languageId', $value = NULL``);
----------------------------------------------

Gibt eine Liste aller definierten Sprachen zurück.
Die Sprachen müssen in der YAML site configuration festgelegt sein.

.. code-block:: php

	// [['title'=>'German', 'iso-639-1'=>'de', 'typo3Language'=>'de', ....], ['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages();
	
	// ['de'=>['title'=>'German', 'typo3Language'=>'de'], 'en'=>['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages('iso-639-1');
	
	// ['de'=>0, 'en'=>1]
	\nn\t3::Environment()->getLanguages('iso-639-1', 'languageId');
	
	// [0=>'de', 1=>'en']
	\nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');

Es gibt auch Helper zum Konvertieren von Sprach-IDs in Sprach-Kürzel
und umgekehrt:

.. code-block:: php

	// --> 0
	\nn\t3::Convert('de')->toLanguageId();
	
	// --> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param string $key``
| ``@param string $value``
| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLanguages( $key = 'languageId', $value = null )
   {
   	$languages = \nn\t3::Settings()->getSiteConfig()['languages'] ?? [];
   	array_walk($languages, fn(&$language) => $language['iso-639-1'] = $language['typo3Language'] = $language['iso-639-1'] ?? substr($language['locale'], 0, 2));
   	if (!$value) {
   		return array_combine( array_column($languages, $key), array_values($languages) );
   	}
   	return array_combine( array_column($languages, $key), array_column($languages, $value) );
   }
   

