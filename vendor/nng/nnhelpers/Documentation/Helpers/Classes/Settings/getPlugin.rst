
.. include:: ../../../../Includes.txt

.. _Settings-getPlugin:

==============================================
Settings::getPlugin()
==============================================

\\nn\\t3::Settings()->getPlugin(``$extName = NULL``);
----------------------------------------------

Get the setup for a specific plugin.

.. code-block:: php

	\nn\t3::Settings()->getPlugin('extname') returns TypoScript from plugin.tx_extname...

Important: Only specify $extensionName if the setup of a FREMDEN extension
is to be fetched or there is no controller context because the call is made e.g.
is made from the backend

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
   

