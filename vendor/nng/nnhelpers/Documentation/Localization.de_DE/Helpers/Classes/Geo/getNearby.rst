
.. include:: ../../../../Includes.txt

.. _Geo-getNearby:

==============================================
Geo::getNearby()
==============================================

\\nn\\t3::Geo()->getNearby(``$params = []``);
----------------------------------------------

Nearby Suche: Findet POIs in der Nähe eines Punktes
Siehe https://bit.ly/43CXxjX für mögliche ``type``-Angaben.

.. code-block:: php

	$results = \nn\t3::Geo()->getNearby(['lat'=>'50.08', 'lng'=>'8.25', 'radius'=>2, 'type'=>['university']])

| ``@param array $params``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getNearby( $params = [] )
   {
   	$params = array_merge([
   		'lat' 		=> 50.08060702093021,
   		'lng'		=> 8.250693320181336,
   		'radius' 	=> 5,
   		'language' 	=> 'de',
   		'types'		=> [],
   	], $params);
   	if (is_string($params['types'])) {
   		$params['types'] = \nn\t3::Arrays( $params['types'] )->trimExplode();
   	}
   	$reqVars = [
   		'location' 		=> "{$params['lat']},{$params['lng']}",
   		'radius' 		=> $params['radius'] * 1000,
   		'type'			=> join('|', $params['types']),
   		'language'		=> $params['language'],
   		'key'			=> $this->getApiKey(),
   	];
   	$result = \nn\t3::Request()->GET( 'https://maps.googleapis.com/maps/api/place/nearbysearch/json', $reqVars );
   	$data = json_decode( $result['content'] ?? '', true );
   	if ($error = $data['error_message'] ?? false) {
   		\nn\t3::Exception( '\nn\t3::Geo()->getCoordinates() : ' . $error );
   	}
   	foreach ($data['results'] as &$result) {
   		$result = $this->parseAddressCompontent( $result );
   	}
   	return $data['results'];
   }
   

