
.. include:: ../../../../Includes.txt

.. _Environment-getCountryByIsocode:

==============================================
Environment::getCountryByIsocode()
==============================================

\\nn\\t3::Environment()->getCountryByIsocode(``$cn_iso_2 = NULL, $field = 'cn_iso_2'``);
----------------------------------------------

A country from the ``static_countries``table
using its country code (e.g. ``DE``)

.. code-block:: php

	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCountryByIsocode ( $cn_iso_2 = null, $field = 'cn_iso_2' ) {
   	if (!ExtensionManagementUtility::isLoaded('static_info_tables')) {
   		$countryProvider = GeneralUtility::makeInstance(CountryProvider::class);
   		$allCountries = \nn\t3::Convert($countryProvider->getAll())->toArray();
   		if ($field == 'cn_iso_2') {
   			return $allCountries[$cn_iso_2] ?? [];
   		}
   		$allCountriesByIso3 = array_combine(
   			array_column($allCountries, 'alpha3IsoCode'),
   			array_values($allCountries)
   		);
   		return $allCountriesByIso3[$cn_iso_2] ?? [];
   	}
   	$data = \nn\t3::Db()->findByValues( 'static_countries', [$field=>$cn_iso_2] );
   	return $data ? array_pop($data) : [];
   }
   

