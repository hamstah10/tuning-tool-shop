
.. include:: ../../../../Includes.txt

.. _Flexform-insertOptions:

==============================================
Flexform::insertOptions()
==============================================

\\nn\\t3::Flexform()->insertOptions(``$config, $a = NULL``);
----------------------------------------------

Fügt Optionen aus TypoScript zur Auswahl in ein FlexForm oder TCA ein.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform->insertOptions</itemsProcFunc>
	    <typoscriptPath>plugin.tx_extname.settings.templates</typoscriptPath>
	    <!-- Alternativ: Settings aus PageTSConfig laden: -->
	    <pageconfigPath>tx_extname.colors</pageconfigPath>
	    <!-- Optional: Eigenen Key aus TypoScript verwenden -->
	    <customKey>value</customKey>
	    <insertEmpty>1</insertEmpty>
	    <insertEmptyLabel>Nichts</insertEmptyLabel>
	    <insertEmptyValue></insertEmptyValue>
	    <hideKey>1</hideKey>
	</config>

Beim Typoscript sind verschiedene Arten des Aufbaus erlaubt:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # Direkte key => label Paare
	    small = Small Design
	    # ... oder: Label im Subarray gesetzt
	    mid {
	        label = Mid Design
	    }
	    # ... oder: Key im Subarray gesetzt, praktisch z.B. für CSS-Klassen
	    10 {
	        label = Big Design
	        classes = big big-thing
	    }
	    # ... oder eine userFunc. Gibt eine der Varianten oben als Array zurück
	    30 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

Die Auswahl kann im TypoScript auf bestimmte Controller-Actions beschränkt werden.
In diesem Beispiel wird die Option "Gelb" nur angezeigt, wenn in der ``switchableControllerAction``
| ``Category->list`` gewählt wurde.

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    yellow {
	        label = Gelb
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
   

