
.. include:: ../../../../Includes.txt

.. _Geo-getCoordinates:

==============================================
Geo::getCoordinates()
==============================================

\\nn\\t3::Geo()->getCoordinates(``$address = '', $returnAll = false, $language = 'de'``);
----------------------------------------------

Adressdaten in Geo-Koordinaten umwandeln (Geo Coding)
Falls die Extension ``nnaddress`` installiert ist, wird diese für die Auflösung verwenden.

.. code-block:: php

	// Abfrage per String, erstes Ergebnis zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	
	// Abfrage per Array
	\nn\t3::Geo()->getCoordinates( ['street'=>'Blumenstrasse 2', 'zip'=>'65189', 'city'=>'Wiesbaden', 'country'=>'DE'] );
	
	// Alle Ergebnisse zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true );
	
	// Alle Ergebnisse in English zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true, 'en' );
	
	// Eingenen Api-Key verwenden
	\nn\t3::Geo( $apiKey )->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	

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

| ``@param array|string $address``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCoordinates ( $address = '', $returnAll = false, $language = 'de' ) {
   	// EXT:nnaddress verwenden, falls vorhanden
   	if (\nn\t3::Environment()->extLoaded('nnaddress')) {
   		$addressService = \nn\t3::injectClass( \Nng\Nnaddress\Services\AddressService::class );
   		if ($coordinates = $addressService->getGeoCoordinatesForAddress( $address )) {
   			return $coordinates;
   		}
   	}
   	if (is_array($address)) {
   		$address = [
   			'street' 	=> $address['street'] ?? '',
   			'zip' 		=> $address['zip'] ?? '',
   			'city' 		=> $address['city'] ?? '',
   			'country' 	=> $address['country'] ?? '',
   		];
   		$address = "{$address['street']}, {$address['zip']} {$address['city']}, {$address['country']}";
   	}
   	$address = trim($address, ', ');
   	$apiKey = $this->getApiKey();
   	if (!$apiKey) return [];
   	$result = \nn\t3::Request()->GET(
   		'https://maps.googleapis.com/maps/api/geocode/json', [
   			'address' 	=> $address,
   			'key'		=> $apiKey,
   			'language'	=> $language,
   		]);
   	$data = json_decode( $result['content'], true );
   	if ($error = $data['error_message'] ?? false) {
   		\nn\t3::Exception( '\nn\t3::Geo()->getCoordinates() : ' . $error );
   	}
   	foreach ($data['results'] as &$result) {
   		$result = $this->parseAddressCompontent( $result );
   	}
   	return $returnAll ? $data['results'] : array_shift( $data['results'] );
   }
   

