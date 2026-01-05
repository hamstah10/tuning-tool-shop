
.. include:: ../../../../Includes.txt

.. _TCA-setConfig:

==============================================
TCA::setConfig()
==============================================

\\nn\\t3::TCA()->setConfig(``$path = '', $override = []``);
----------------------------------------------

Overwrite a configuration of the TCA, e.g. to overwrite a ``mask field`` with its own renderType
or to change core settings in the TCA on the ``pages`` or ``tt_content`` tables.

The following example sets/overwrites the ``config array`` in the ``TCA`` under:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['mycol']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setConfig('tt_content.columns.mycol', [
	    'renderType' => 'nnsiteIconCollection',
	    'iconconfig' => 'tx_nnsite.iconcollection',
	]);

See also ``\nn\t3::TCA()->setContentConfig()`` for a short version of this method when it comes to
the table ``tt_content`` and ``\nn\t3::TCA()->setPagesConfig()`` for the table ``pages``

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
   

