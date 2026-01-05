
.. include:: ../../../Includes.txt

.. _Geo:

==============================================
Geo
==============================================

\\nn\\t3::Geo()
----------------------------------------------

Calculating and converting geopositions and data.

To convert geo-coordinates into address data and vice versa, a Google Maps ApiKey
must be created and stored in the Extension Manager for nnhelpers. Alternatively, you can
a separate ApiKey can be specified during initialization:

.. code-block:: php

	nn\t3::Geo( $myApiKey )->getCoordinates('...');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Geo()->autoComplete(``$params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Autocomplete search: Finds addresses (names) based on a search term

.. code-block:: php

	$results = \nn\t3::Geo()->autoComplete('99grad Wiesbaden');
	$results = \nn\t3::Geo()->autoComplete(['keyword'=>'99grad', 'lat'=>'50.08', 'lng'=>'8.25', 'radius'=>2, 'type'=>['university']]);

| ``@param array|string $params``
| ``@return array``

| :ref:`➜ Go to source code of Geo::autoComplete() <Geo-autoComplete>`

\\nn\\t3::Geo()->getAddress(``$lng = 8.2506933201813, $lat = 50.08060702093, $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert geo-coordinates into address data (reverse geo coding)
If the extension ``nnaddress`` is installed, it will be used for the resolution.

.. code-block:: php

	// Return the first result
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021 );
	
	// Return ALL results
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true );
	
	// return ALL results in English
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true, 'en' );
	
	// $lng and $lat can also be passed as an array
	\nn\t3::Geo()->getAddress( ['lat'=>50.08060702093021, 'lng'=>8.250693320181336] );
	
	// Use your own API key?
	\nn\t3::Geo( $apiKey )->getAddress( 8.250693320181336, 50.08060702093021 );

Example for return:

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

| :ref:`➜ Go to source code of Geo::getAddress() <Geo-getAddress>`

\\nn\\t3::Geo()->getApiKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Get api key for methods in this class.
The Api key can either be specified when initializing ``\nn\t3::Geo()`` 
or in the Extension Manager for ``nnhelpers``.

.. code-block:: php

	\nn\t3::Geo( $myApiKey )->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	\nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');

| ``@return string``

| :ref:`➜ Go to source code of Geo::getApiKey() <Geo-getApiKey>`

\\nn\\t3::Geo()->getCoordinates(``$address = '', $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert address data into geo-coordinates (geo coding)
If the extension ``nnaddress`` is installed, it will be used for the resolution.

.. code-block:: php

	// Query via string, return first result
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	
	// Query via array
	\nn\t3::Geo()->getCoordinates( ['street'=>'Blumenstrasse 2', 'zip'=>'65189', 'city'=>'Wiesbaden', 'country'=>'DE'] );
	
	// Return all results
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true );
	
	// Return all results in English
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true, 'en' );
	
	// Use your own api key
	\nn\t3::Geo( $apiKey )->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	

Example for return:

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

| :ref:`➜ Go to source code of Geo::getCoordinates() <Geo-getCoordinates>`

\\nn\\t3::Geo()->getNearby(``$params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Nearby search: Finds POIs in the vicinity of a point
See https://bit.ly/43CXxjX for possible ``type specifications``.

.. code-block:: php

	$results = \nn\t3::Geo()->getNearby(['lat'=>'50.08', 'lng'=>'8.25', 'radius'=>2, 'type'=>['university']])

| ``@param array $params``
| ``@return array``

| :ref:`➜ Go to source code of Geo::getNearby() <Geo-getNearby>`

\\nn\\t3::Geo()->parseAddressCompontent(``$row = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Normalizes a result from the GeoCoding

| ``@param array $row``
| ``@return array``

| :ref:`➜ Go to source code of Geo::parseAddressCompontent() <Geo-parseAddressCompontent>`

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert GPS coordinates into readable latitude/longitude coordinates

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

| :ref:`➜ Go to source code of Geo::toGps() <Geo-toGps>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
