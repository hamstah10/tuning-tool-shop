
.. include:: ../../../../Includes.txt

.. _Settings-getFullTypoScriptFromConfigurationManager:

==============================================
Settings::getFullTypoScriptFromConfigurationManager()
==============================================

\\nn\\t3::Settings()->getFullTypoScriptFromConfigurationManager();
----------------------------------------------

Get complete TypoScript via the Configuration Manager.

A simple wrapper for the core function but with ``try { ... } catch()``
Fallback.

Does not work in every context - e.g. not in the CLI context!
Better: ``\nn\t3::Settings()->parseTypoScriptForPage();`` use.

Returns the notation with dots. This can be done via
| ``\nn\t3::TypoScript()->convertToPlainArray()`` into a normal`` array``
be converted into a normal array.

.. code-block:: php

	// ==> ['plugin.']['example.'][...]
	$setup = \nn\t3::Settings()->getFullTypoScriptFromConfigurationManager();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFullTypoScriptFromConfigurationManager()
   {
   	try {
   		$configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
   		$setup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
   		return $setup;
   	} catch ( \Exception $e ) {
   		// silence is golden
   		return [];
   	}
   }
   

