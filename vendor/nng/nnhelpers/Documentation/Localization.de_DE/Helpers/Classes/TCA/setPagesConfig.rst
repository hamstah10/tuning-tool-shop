
.. include:: ../../../../Includes.txt

.. _TCA-setPagesConfig:

==============================================
TCA::setPagesConfig()
==============================================

\\nn\\t3::TCA()->setPagesConfig(``$field = '', $override = [], $shortParams = NULL``);
----------------------------------------------

Eine Konfiguration des TCA für die Tabelle ``pages`` setzen oder überschreiben.

Diese Beispiel überschreibt im ``TCA`` das ``config``-Array der Tabelle ``pages`` für:

.. code-block:: php

	$GLOBALS['TCA']['pages']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setPagesConfig( 'title', 'text' );            // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setPagesConfig( 'title', 'text', 10 );        // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setPagesConfig( 'title', ['type'=>'text', 'rows'=>2] ); // ['type'=>'text', 'rows'=>2]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setPagesConfig( $field = '', $override = [], $shortParams = null )
   {
   	if (!isset($GLOBALS['TCA']['pages']['columns'][$field]['config'])) {
   		$GLOBALS['TCA']['pages']['columns'][$field]['config'] = [];
   	}
   	$config = &$GLOBALS['TCA']['pages']['columns'][$field]['config'];
   	return $config = \nn\t3::Arrays()->merge( $config, $this->getConfigForType($override, $shortParams) );
   }
   

