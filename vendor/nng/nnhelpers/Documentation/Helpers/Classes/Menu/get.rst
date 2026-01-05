
.. include:: ../../../../Includes.txt

.. _Menu-get:

==============================================
Menu::get()
==============================================

\\nn\\t3::Menu()->get(``$rootPid = NULL, $config = []``);
----------------------------------------------

Returns an array with a hierarchical tree structure of the navigation
returns. Can be used to render a menu.

.. code-block:: php

	// Get structure for current page ID (pid)
	\nn\t3::Menu()->get();
	
	// Get structure for page 123
	\nn\t3::Menu()->get( 123 );

There is also a ViewHelper for this:

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
   

