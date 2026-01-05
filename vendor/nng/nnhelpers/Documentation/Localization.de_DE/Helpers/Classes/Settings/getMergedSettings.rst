
.. include:: ../../../../Includes.txt

.. _Settings-getMergedSettings:

==============================================
Settings::getMergedSettings()
==============================================

\\nn\\t3::Settings()->getMergedSettings(``$extensionName = NULL, $ttContentUidOrSetupArray = []``);
----------------------------------------------

Merge aus TypoScript-Setup für ein Plugin und seinem Flexform holen.
Gibt das TypoScript-Array ab ``plugin.tx_extname.settings``... zurück.

Wichtig: $extensionName nur angeben, wenn das Setup einer FREMDEN Extension
geholt werden soll oder es keinen Controller-Context gibt, weil der
Aufruf aus dem Backend gemacht wird... sonst werden die FlexForm-Werte nicht berücksichtigt!

Im FlexForm ``<settings.flexform.varName>`` verwenden!
| ``<settings.flexform.varName>`` überschreibt dann ``settings.varName`` im TypoScript-Setup

| ``$ttContentUidOrSetupArray`` kann uid eines ``tt_content``-Inhaltselementes sein
oder ein einfaches Array zum Überschreiben der Werte aus dem TypoScript / FlexForm

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
   

