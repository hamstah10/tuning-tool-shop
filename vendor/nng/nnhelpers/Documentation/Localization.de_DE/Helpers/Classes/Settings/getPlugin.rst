
.. include:: ../../../../Includes.txt

.. _Settings-getPlugin:

==============================================
Settings::getPlugin()
==============================================

\\nn\\t3::Settings()->getPlugin(``$extName = NULL``);
----------------------------------------------

Das Setup für ein bestimmtes Plugin holen.

.. code-block:: php

	\nn\t3::Settings()->getPlugin('extname') ergibt TypoScript ab plugin.tx_extname...

Wichtig: $extensionName nur angeben, wenn das Setup einer FREMDEN Extension
geholt werden soll oder es keinen Controller-Context gibt, weil der Aufruf z.B.
aus dem Backend gemacht wird

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPlugin($extName = null)
   {
   	if (!$extName) {
   		try {
   			$configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
   			$setup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK) ?: [];
   		return $setup;
   		} catch ( \Exception $e ) {
   			// silence is golden
   		}
   	}
   	// Fallback: Setup für das Plugin aus globaler TS-Konfiguration holen
   	$setup = $this->getFullTyposcript();
   	if (!$setup || !($setup['plugin'] ?? false)) return [];
   	if (isset($setup['plugin'][$extName])) {
   		return $setup['plugin'][$extName];
   	}
   	if (isset($setup['plugin']["tx_{$extName}"])) {
   		return $setup['plugin']["tx_{$extName}"];
   	}
   	return $setup['plugin']["tx_{$extName}_{$extName}"] ?? [];
   }
   

