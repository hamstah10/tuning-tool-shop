
.. include:: ../../../../Includes.txt

.. _TCA-setContentConfig:

==============================================
TCA::setContentConfig()
==============================================

\\nn\\t3::TCA()->setContentConfig(``$field = '', $override = [], $shortParams = NULL``);
----------------------------------------------

Eine Konfiguration des TCA für die Tabelle ``tt_content`` setzen oder überschreiben.

Diese Beispiel überschreibt im ``TCA`` das ``config``-Array der Tabelle ``tt_content`` für:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setContentConfig( 'header', 'text' );     // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setContentConfig( 'header', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setContentConfig( 'header', ['type'=>'text', 'rows'=>10] ); // ['type'=>'text', 'rows'=>10]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setContentConfig( $field = '', $override = [], $shortParams = null )
   {
   	if (!isset($GLOBALS['TCA']['tt_content']['columns'][$field]['config'])) {
   		$GLOBALS['TCA']['tt_content']['columns'][$field]['config'] = [];
   	}
   	$config = &$GLOBALS['TCA']['tt_content']['columns'][$field]['config'];
   	return $config = \nn\t3::Arrays()->merge( $config, $this->getConfigForType($override, $shortParams) );
   }
   

