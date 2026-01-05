
.. include:: ../../../../Includes.txt

.. _Geo-autoComplete:

==============================================
Geo::autoComplete()
==============================================

\\nn\\t3::Geo()->autoComplete(``$params = []``);
----------------------------------------------

Autocomplete Suche: Findet Adressen (Namen) anhand eines Suchwortes

.. code-block:: php

	$results = \nn\t3::Geo()->autoComplete('99grad Wiesbaden');
	$results = \nn\t3::Geo()->autoComplete(['keyword'=>'99grad', 'lat'=>'50.08', 'lng'=>'8.25', 'radius'=>2, 'type'=>['university']]);

| ``@param array|string $params``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function autoComplete( $params = [] )
   {
   	if (is_string($params)) {
   		$params = ['keyword'=>$params];
   	}
   	$params = array_merge([
   		'language' 	=> 'de',
   		'types'		=> [],
   	], $params);
   	if (is_string($params['types'])) {
   		$params['types'] = \nn\t3::Arrays( $params['types'] )->trimExplode();
   	}
   	$reqVars = [
   		'input'			=> $params['keyword'],
   		'language'		=> $params['language'],
   		'key'			=> $this->getApiKey(),
   	];
   	if ($params['lat'] ?? false) {
   		$reqVars['location'] = "{$params['lat']},{$params['lng']}";
   	}
   	if ($params['radius'] ?? false) {
   		$reqVars['radius'] = $params['radius'] * 1000;
   	}
   	if ($params['type'] ?? false) {
   		$reqVars['type'] = join('|', $params['types']);
   	}
   	$result = \nn\t3::Request()->GET( 'https://maps.googleapis.com/maps/api/place/autocomplete/json', $reqVars );
   	$data = json_decode( $result['content'] ?? '', true );
   	if ($error = $data['error_message'] ?? false) {
   		\nn\t3::Exception( '\nn\t3::Geo()->getCoordinates() : ' . $error );
   	}
   	foreach ($data['predictions'] as &$result) {
   		$result = [
   			'name' 				=> $result['structured_formatting']['main_text'] ?? '',
   			'address' 			=> $result['structured_formatting']['secondary_text'] ?? '',
   			'google_place_id' 	=> $result['place_id'],
   		];
   	}
   	return $data['predictions'];
   }
   

