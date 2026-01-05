
.. include:: ../../../../Includes.txt

.. _Geo-getApiKey:

==============================================
Geo::getApiKey()
==============================================

\\nn\\t3::Geo()->getApiKey();
----------------------------------------------

Api-Key für Methoden in dieser Klasse holen.
Der Api-Key kann entweder beim Initialisieren von ``\nn\t3::Geo()`` angegeben werden
oder im Extension Manager für ``nnhelpers``.

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
   

