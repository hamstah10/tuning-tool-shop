
.. include:: ../../../../Includes.txt

.. _Geo-parseAddressCompontent:

==============================================
Geo::parseAddressCompontent()
==============================================

\\nn\\t3::Geo()->parseAddressCompontent(``$row = []``);
----------------------------------------------

Normalisiert ein Ergebnis aus dem GeoCoding

| ``@param array $row``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseAddressCompontent( $row = [] )
   {
   	if (!$row) $row = [];
   	$address = [];
   	$addressShort = [];
   	foreach ($row['address_components'] as $r) {
   		foreach ($r['types'] as $n) {
   			$address[$n] = $r['long_name'];
   			$addressShort[$n] = $r['short_name'];
   		}
   	}
   	$address['name'] = $row['name'] ?? '';
   	$address['country_short'] = $addressShort['country'] ?? '';
   	$address['street'] = trim(($address['route'] ?? '') . ' ' . ($address['street_number'] ?? '') );
   	$address['zip'] = $address['postal_code'] ?? '';
   	$address['city'] = $address['locality'] ?? '';
   	$address['formatted_phone_number'] = $address['phone'] = $row['formatted_phone_number'] ?? '';
   	$address['international_phone_number'] = $row['international_phone_number'] ?? '';
   	$address['lat'] = $row['geometry']['location']['lat'] ?? null;
   	$address['lng'] = $row['geometry']['location']['lng'] ?? null;
   	$address['google_id'] = $row['id'] ?? '';
   	$address['google_place_id'] = $row['place_id'] ?? '';
   	$address['types'] = $row['types'] ?? [];
   	if (!$address['street'] && ($row['vicinity'] ?? false)) {
   		$parts = explode( ',', $row['vicinity'] );
   		$address['street'] = trim($parts[0]);
   		$address['city'] = trim($parts[1]);
   	}
   	return $address;
   }
   

