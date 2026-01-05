
.. include:: ../../../../Includes.txt

.. _Settings-getMergedSettings:

==============================================
Settings::getMergedSettings()
==============================================

\\nn\\t3::Settings()->getMergedSettings(``$extensionName = NULL, $ttContentUidOrSetupArray = []``);
----------------------------------------------

Get merge from TypoScript setup for a plugin and its flexform.
Returns the TypoScript array from ``plugin.tx_extname.settings.``.. back.

Important: Only specify $extensionName if the setup of a FREMDEN extension
is to be fetched or there is no controller context because the
call is made from the backend... otherwise the FlexForm values are not taken into account!

In the FlexForm ```` use!
| ```` Then overwrite ``settings.varName`` in the TypoScript setup

| ``$ttContentUidOrSetupArray`` can be the uid of a ``tt_content content element``
or a simple array to overwrite the values from the TypoScript / FlexForm

.. code-block:: php

	\nn\t3::Settings()->getMergedSettings();
	\nn\t3::Settings()->getMergedSettings( 'nnsite' );
	\nn\t3::Settings()->getMergedSettings( $extensionName, $ttContentUidOrSetupArray );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getMergedSettings( $extensionName = null, $ttContentUidOrSetupArray = [] )
   {
   	// Setup für das aktuelle Plugin holen, inkl. Felder aus dem FlexForm
   	try {
   		$configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
   		$pluginSettings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, $extensionName) ?: [];
   	} catch ( \Exception $e ) {
   		$pluginSettings = [];
   	}
   	// Fallback: Setup für das Plugin aus globaler TS-Konfiguration holen
   	if (!$pluginSettings) {
   		$setup = $this->getPlugin( $extensionName );
   		$pluginSettings = $setup['settings'] ?? [];
   	}
   	// Eine tt_content.uid wurde übergeben. FlexForm des Elementes aus DB laden
   	if ($ttContentUidOrSetupArray && !is_array($ttContentUidOrSetupArray)) {
   		$flexform =  \nn\t3::Flexform()->getFlexform($ttContentUidOrSetupArray);
   		$ttContentUidOrSetupArray =  $flexform['settings'] ?? [];
   	}
   	// Im Flexform sollten die Felder über settings.flexform.varname definiert werden
   	$flexformSettings = $ttContentUidOrSetupArray['flexform'] ?? $pluginSettings['flexform'] ?? [];
   	// Merge
   	ArrayUtility::mergeRecursiveWithOverrule( $pluginSettings, $flexformSettings, true, false );
   	// Referenz zu settings.flexform behalten
   	if ($flexformSettings) {
   		$pluginSettings['flexform'] = $flexformSettings;
   	}
   	return $pluginSettings;
   }
   

