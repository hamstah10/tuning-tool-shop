
.. include:: ../../../../Includes.txt

.. _Settings-getFullTypoScriptFromConfigurationManager:

==============================================
Settings::getFullTypoScriptFromConfigurationManager()
==============================================

\\nn\\t3::Settings()->getFullTypoScriptFromConfigurationManager();
----------------------------------------------

Vollständiges TypoScript über den Configuration Manager holen.

Ein simpler Wrapper für die Core-Funktion aber mit ``try { ... } catch()``
Fallback.

Funktioniert nicht in jedem Kontext – z.B. nicht im CLI-Kontext!
Besser: ``\nn\t3::Settings()->parseTypoScriptForPage();`` verwenden.

Gibt die Notation mit Punkten zurück. Das kann per
| ``\nn\t3::TypoScript()->convertToPlainArray()`` in ein
normales Array umgewandelt werden.

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
   

