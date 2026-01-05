
.. include:: ../../../../Includes.txt

.. _Environment-getCountries:

==============================================
Environment::getCountries()
==============================================

\\nn\\t3::Environment()->getCountries(``$lang = 'de', $key = 'cn_iso_2'``);
----------------------------------------------

Alle im System verfügbaren Ländern holen

.. code-block:: php

	\nn\t3::Environment()->getCountries();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCountries ( $lang = 'de', $key = 'cn_iso_2' ) {
   	if (!ExtensionManagementUtility::isLoaded('static_info_tables')) {
   		$countryProvider = GeneralUtility::makeInstance(CountryProvider::class);
   		$allCountries = \nn\t3::Convert($countryProvider->getAll())->toArray();
   		if ($lang != 'en') {
   			$languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->create($lang);
   			foreach ($allCountries as &$country) {
   				$country['name'] = $languageService->sL($country['localizedNameLabel']);
   				$country['officialName'] = $languageService->sL($country['localizedOfficialNameLabel']);
   			}
   		}
   		if ($key != 'cn_iso_2') {
   			$results = array_column($allCountries, 'name', 'alpha3IsoCode');
   		} else {
   			$results = array_combine(
   				array_keys($allCountries),
   				array_column($allCountries, 'name')
   			);
   		}
   		if (extension_loaded('intl')) {
   			$coll = new \Collator('de_DE');
   			uasort($results, function($a, $b) use ($coll) {
   				return $coll->compare($a, $b);
   			});
   		} else {
   			$oldLocale = setlocale(LC_COLLATE, 0);
   			setlocale(LC_COLLATE, 'de_DE.utf8');
   			asort($results, SORT_LOCALE_STRING);
   			setlocale(LC_COLLATE, $oldLocale);
   		}
   		return $results;
   	}
   	$data = \nn\t3::Db()->findAll( 'static_countries' );
   	return \nn\t3::Arrays($data)->key($key)->pluck('cn_short_'.$lang)->toArray();
   }
   

