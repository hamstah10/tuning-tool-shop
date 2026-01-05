
.. include:: ../../../../Includes.txt

.. _TCA-setConfig:

==============================================
TCA::setConfig()
==============================================

\\nn\\t3::TCA()->setConfig(``$path = '', $override = []``);
----------------------------------------------

Eine Konfiguration des TCA überschreiben, z.B. um ein ``mask``-Feld mit einem eigenen renderType zu
überschreiben oder Core-Einstellungen im TCA an den Tabellen ``pages`` oder ``tt_content`` zu ändern.

Folgendes Beispiel setzt/überschreibt im ``TCA`` das ``config``-Array unter:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['mycol']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setConfig('tt_content.columns.mycol', [
	    'renderType' => 'nnsiteIconCollection',
	    'iconconfig' => 'tx_nnsite.iconcollection',
	]);

Siehe auch ``\nn\t3::TCA()->setContentConfig()`` für eine Kurzfassung dieser Methode, wenn es um
die Tabelle ``tt_content`` geht und ``\nn\t3::TCA()->setPagesConfig()`` für die Tabelle ``pages``

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setConfig( $path = '', $override = [] )
   {
   	if ($config = &$this->getConfig( $path )) {
   		$config = \nn\t3::Arrays()->merge( $config, $override );
   	}
   	return $config;
   }
   

