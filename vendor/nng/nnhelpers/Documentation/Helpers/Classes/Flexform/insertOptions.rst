
.. include:: ../../../../Includes.txt

.. _Flexform-insertOptions:

==============================================
Flexform::insertOptions()
==============================================

\\nn\\t3::Flexform()->insertOptions(``$config, $a = NULL``);
----------------------------------------------

Inserts options from TypoScript for selection in a FlexForm or TCA.

.. code-block:: php

	
	    select
	    
	    nn\t3\Flexform->insertOptions
	    plugin.tx_extname.settings.templates
	    
	    tx_extname.colors
	    
	    value
	    1
	    Nothing
	    
	    1
	

Various types of structure are permitted for the Typoscript:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # Direct key => label pairs
	    small = Small Design
	    # ... or: Label set in subarray
	    mid {
	        label = Mid Design
	    }
	    # ... or: Key set in subarray, practical e.g. for CSS classes
	    10 {
	        label = Big Design
	        classes = big big-thing
	    }
	    # ... or a userFunc. Returns one of the variants above as an array
	    30 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

The selection can be restricted to certain controller actions in the TypoScript.
In this example, the "Yellow" option is only displayed if the ``switchableControllerAction``
| ``Category->list`` has been selected.

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    yellow {
	        label = Yellow
	        controllerAction = Category->list,...
	    }
	}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertOptions( $config, $a = null )
   {
   	if ($path = $config['config']['typoscriptPath'] ?? false) {
   		// 'typoscriptPath' angegeben: Standard TypoScript-Setup verwenden
   		$setup = \nn\t3::Settings()->getFromPath( $path );
   	} elseif ( $path = $config['config']['pageconfigPath'] ?? false) {
   		// 'pageconfigPath' angegeben: PageTSConfig verwenden
   		$setup = \nn\t3::Settings()->getPageConfig( $path );
   	}
   	if (!$setup) {
   		if ($config['items'] ?? false) return $config;
   		$config['items'] = [
   			['label' => 'Keine Konfiguration gefunden - Auswahl kann in '.$path.' definiert werden', 'value'=>'']
   		];
   		return $config;
   	}
   	$respectControllerAction = false;
   	// TypoScript setup vorbereiten
   	foreach ($setup as $k=>$v) {
   		// controllerAction in Typoscript gesetzt?
   		if (is_array($v) && ($v['controllerAction'] ?? false)) {
   			$respectControllerAction = true;
   		}
   		// userFunc vorhanden? Dann auflösen...
   		if (is_array($v) && ($v['userFunc'] ?? false)) {
   			$result = \nn\t3::call( $v['userFunc'], $v );
   			unset($setup[$k]);
   			$setup = \nn\t3::Arrays($result)->merge($setup);
   		}
   	}
   	// eigenen Key verwenden?
   	$customKey = $config['config']['customKey'] ?? '';
   	// Ausgewählte Action aus FlexForm 'switchableControllerActions' holen
   	$selectedAction = $config['row']['switchableControllerActions'] ?? false;
   	// Leeren Wert einfügen?
   	if ($config['config']['insertEmpty'] ?? false) {
   		$label = $config['config']['insertEmptyLabel'] ?? '';
   		$value = $config['config']['insertEmptyValue'] ?? 0;
   		$config['items'] = array_merge( $config['items'], [[$label, $value, '']] );
   	}
   	// Key in Klammern zeigen?
   	$hideKey = ($config['config']['hideKey'] ?? 0) == 1;
   	foreach ($setup as $k=>$v) {
   		if (is_array($v)) {
   			$label = $v['_typoScriptNodeValue'] ?? $v['label'] ?? $v['title'] ?? $v;
   			$key = $v[$customKey] ?? $v['classes'] ?? $k;
   			$keyStr = $hideKey ? '' : " ({$key})";
   			$limitToAction = \nn\t3::Arrays($v['controllerAction'] ?? '')->trimExplode();
   			if ($limitToAction && $selectedAction) {
   				if (array_intersect($limitToAction, $selectedAction)) {
   					$config['items'] = array_merge( $config['items'], [['label'=>$label.$keyStr, 'value'=>$key]] );
   				}
   			} else {
   				$config['items'] = array_merge( $config['items'], [['label'=>$label.$keyStr, 'value'=>$key]] );
   			}
   		} else {
   			$key = $v[$customKey] ?? $v['classes'] ?? $k;
   			$keyStr = $hideKey ? '' : " ({$key})";
   			$config['items'] = array_merge( $config['items'], [['label'=>$v.$keyStr, 'value'=>$key]] );
   		}
   	}
   	return $config;
   }
   

