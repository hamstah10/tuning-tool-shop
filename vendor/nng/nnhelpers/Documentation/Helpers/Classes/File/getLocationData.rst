
.. include:: ../../../../Includes.txt

.. _File-getLocationData:

==============================================
File::getLocationData()
==============================================

\\nn\\t3::File()->getLocationData(``$filename = ''``);
----------------------------------------------

Get EXIF GEO data for file.
Address data is determined automatically if possible

.. code-block:: php

	\nn\t3::File()->getLocationData( 'yellowstone.jpg' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLocationData($filename = '')
   {
   	if (!function_exists('exif_read_data')) return [];
   	$rawExif = @\exif_read_data($filename);
   	$exif = [];
   	if ($rawExif) {
   		$exif['lat'] = \nn\t3::Geo()->toGps($rawExif['GPSLatitude'], $rawExif['GPSLatitudeRef']);
   		$exif['lng'] = \nn\t3::Geo()->toGps($rawExif['GPSLongitude'], $rawExif['GPSLongitudeRef']);
   		$exif = \nn\t3::Arrays($exif)->merge(\nn\t3::Geo()->getAddress($exif['lng'], $exif['lat']));
   	}
   	return $exif;
   }
   

