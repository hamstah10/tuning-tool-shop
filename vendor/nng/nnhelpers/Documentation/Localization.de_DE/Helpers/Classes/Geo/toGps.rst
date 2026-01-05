
.. include:: ../../../../Includes.txt

.. _Geo-toGps:

==============================================
Geo::toGps()
==============================================

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
----------------------------------------------

GPS-Koordinaten in lesbare Latitude/Longitude-Koordinaten umrechnen

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toGps( $coordinate, $hemisphere )
   {
   	if (!$coordinate || !$hemisphere) return 0;
   	for ($i = 0; $i < 3; $i++) {
   		$part = explode('/', $coordinate[$i]);
   		if (count($part) == 1) {
   			$coordinate[$i] = $part[0];
   		} else if (count($part) == 2) {
   			$coordinate[$i] = floatval($part[0])/floatval($part[1]);
   		} else {
   			$coordinate[$i] = 0;
   		}
   	}
   	list($degrees, $minutes, $seconds) = $coordinate;
   	$sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
   	return $sign * ($degrees + $minutes/60 + $seconds/3600);
   }
   

