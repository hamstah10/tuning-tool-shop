
.. include:: ../../../../Includes.txt

.. _Registry-fluidNamespace:

==============================================
Registry::fluidNamespace()
==============================================

\\nn\\t3::Registry()->fluidNamespace(``$referenceNames = [], $namespaces = []``);
----------------------------------------------

Register global namespace for Fluid.
Mostly used in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->fluidNamespace( 'nn', 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], ['Nng\Nnsite\ViewHelpers', 'Other\Namespace\Fallback'] );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fluidNamespace ( $referenceNames = [], $namespaces = [] )
   {
   	if (is_string($referenceNames)) $referenceNames = [$referenceNames];
   	if (is_string($namespaces)) $namespaces = [$namespaces];
   	foreach ($referenceNames as $key) {
   		$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces'][$key] = $namespaces;
   	}
   }
   

