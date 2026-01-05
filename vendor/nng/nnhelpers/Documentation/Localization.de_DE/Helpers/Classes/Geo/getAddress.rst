
.. include:: ../../../../Includes.txt

.. _Geo-getAddress:

==============================================
Geo::getAddress()
==============================================

\\nn\\t3::Geo()->getAddress(``$lng = 8.2506933201813, $lat = 50.08060702093, $returnAll = false, $language = 'de'``);
----------------------------------------------

Geo-Koordinaten in Adress-Daten umwandeln (Reverse Geo Coding)
Falls die Extension ``nnaddress`` installiert ist, wird diese für die Auflösung verwenden.

.. code-block:: php

	// Erstes Ergebnis zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021 );
	
	// ALLE Ergebnisse zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true );
	
	// ALLE Ergebnisse in Englisch zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true, 'en' );
	
	// $lng und $lat kann auch als Array übergeben werden
	\nn\t3::Geo()->getAddress( ['lat'=>50.08060702093021, 'lng'=>8.250693320181336] );
	
	// Eigenen API-Key verwenden?
	\nn\t3::Geo( $apiKey )->getAddress( 8.250693320181336, 50.08060702093021 );

Beispiel für Rückgabe:

.. code-block:: php

	[
	    'lat' => 50.0805069,
	    'lng' => 8.2508677,
	    'street' => 'Blumenstrass 2',
	    'zip' => '65189',
	    'city' => 'Wiesbaden',
	    ...
	]

| ``@param array|float $lng``
| ``@param float|bool $lat``
| ``@param bool $returnAll``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAddress ( $lng = 8.250693320181336, $lat = 50.08060702093021, $returnAll = false, $language = 'de' ) {
   	$results = [];
   	if (is_array($lng)) {
   		$returnAll = $lat;
   		$lat = $lng['lat'] ?? 0;
   		$lng = $lng['lng'] ?? 0;
   	}
   	// EXT:nnaddress verwenden, falls vorhanden
   	if (\nn\t3::Environment()->extLoaded('nnaddress')) {
   		$addressService = GeneralUtility::makeInstance( \Nng\Nnaddress\Services\AddressService::class );
   		if ($addresses = $addressService->getAddressForGeoCoordinates( ['lng'=>$lng, 'lat'=>$lat] )) {
   			foreach ($addresses as $address) {
   				$results[] = [
   					'street' 	=> $address['street'],
   					'zip' 		=> $address['postal_code'],
   					'city' 		=> $address['locality'],
   					'country' 	=> $address['political'],
   				];
   			}
   		}
   	} else {
   		$apiKey = $this->getApiKey();
   		if (!$apiKey) return [];
   		$result = \nn\t3::Request()->GET(
   			'https://maps.googleapis.com/maps/api/geocode/json', [
   				'latlng' 	=> $lat . ',' . $lng,
   				'key'		=> $apiKey,
   				'language'	=> $language,
   			]);
   		$data = json_decode( $result['content'], true );
   		foreach ($data['results'] as &$result) {
   			$result = $this->parseAddressCompontent( $result );
   		}
   		$results = $data['results'];
   	}
   	if (!$results) return [];
   	return $returnAll ? $results : array_shift($results);
   }
   

