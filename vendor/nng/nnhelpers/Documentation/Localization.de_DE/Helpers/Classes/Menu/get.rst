
.. include:: ../../../../Includes.txt

.. _Menu-get:

==============================================
Menu::get()
==============================================

\\nn\\t3::Menu()->get(``$rootPid = NULL, $config = []``);
----------------------------------------------

Gibt ein Array mit hierarchischer Baum-Struktur der Navigation
zurück. Kann zum Rendern eines Menüs genutzt werden.

.. code-block:: php

	// Struktur für aktuelle Seiten-ID (pid) holen
	\nn\t3::Menu()->get();
	
	// Struktur für Seite 123 holen
	\nn\t3::Menu()->get( 123 );

Es gibt auch einen ViewHelper dazu:

.. code-block:: php

	{nnt3:menu.directory(pageUid:123, ...)}

| ``@param int $rootPid``
| ``@param array $config``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $rootPid = null, $config = [] )
   {
   	$cObj = \nn\t3::Tsfe()->cObj();
   	$pid = $rootPid ?: \nn\t3::Page()->getPid();
   	$menuProcessorConfiguration = [
   		// wieviele Menüpunkt überspringen
   		'begin' 			=> '0',
   		// wieviele Levels zeigen
   		'levels' 			=> 99,
   		// erst ab diesem Level rendern (1 = nur Submenüs ab dem 2. Level im Seitbaum)
   		'entryLevel' 		=> $config['entryLevel'] ?? 0,
   		'special' 			=> $config['type'] ?? 'directory',
   		'special.' 			=> [
   			'value' => $pid
   		],
   		'includeNotInMenu' 	=> $config['showHiddenInMenu'] ?? 0,
   		'excludeUidList' 	=> $config['excludePages'] ?? '',
   		'as' 				=> 'children',
   		'expandAll' 		=> 1,
   		'includeSpacer' 	=> 1,
   		'titleField' 		=> 'nav_title // title',
   	];
   	if ($entryLevel = $config['entryLevel'] ?? false) {
   		$menuProcessorConfiguration['special.']['value.'] = [
   			'data' => 'leveluid:' . $entryLevel
   		];
   	}
   	$menuProcessor = GeneralUtility::makeInstance(MenuProcessor::class);
   	$menuProcessor->setContentObjectRenderer($cObj);
   	$result = $menuProcessor->process($cObj, [], $menuProcessorConfiguration, []);
   	return $result;
   }
   

