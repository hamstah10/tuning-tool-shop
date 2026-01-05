
.. include:: ../../../../Includes.txt

.. _Geo-getApiKey:

==============================================
Geo::getApiKey()
==============================================

\\nn\\t3::Geo()->getApiKey();
----------------------------------------------

Get api key for methods in this class.
The Api key can either be specified when initializing ``\nn\t3::Geo()`` 
or in the Extension Manager for ``nnhelpers``.

.. code-block:: php

	\nn\t3::Geo( $myApiKey )->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	\nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getApiKey() {
   	$apiKey = $this->config['apiKey'] ?? \nn\t3::Environment()->getExtConf('nnhelpers')['googleGeoApiKey'] ?? false;
   	return $apiKey;
   }
   

