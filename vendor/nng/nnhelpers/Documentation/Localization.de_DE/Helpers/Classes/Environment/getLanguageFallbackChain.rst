
.. include:: ../../../../Includes.txt

.. _Environment-getLanguageFallbackChain:

==============================================
Environment::getLanguageFallbackChain()
==============================================

\\nn\\t3::Environment()->getLanguageFallbackChain(``$langUid = true``);
----------------------------------------------

Gibt eine Liste der Sprachen zurück, die verwendet werden sollen, falls
z.B. eine Seite oder ein Element nicht in der gewünschten Sprache existiert.

Wichtig: Die Fallback-Chain enthält an erster Stelle die aktuelle bzw. in $langUid
übergebene Sprache.

.. code-block:: php

	// Einstellungen für aktuelle Sprache verwenden (s. Site-Config YAML)
	\nn\t3::Environment()->getLanguageFallbackChain();   // --> z.B. [0] oder [1,0]
	
	// Einstellungen für eine bestimmte Sprache holen
	\nn\t3::Environment()->getLanguageFallbackChain( 1 );
	// --> [1,0] - falls Fallback in Site-Config definiert wurde und der fallbackMode auf "fallback" steht
	// --> [1] - falls es keinen Fallback gibt oder der fallbackMode auf "strict" steht

| ``@param string|boolean $returnKey``
| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLanguageFallbackChain( $langUid = true )
   {
   	if ($langUid === true) {
   		$langUid = $this->getLanguage();
   	}
   	$langSettings = $this->getLanguages()[$langUid] ?? [];
   	$fallbackType = $langSettings['fallbackType'] ?? 'strict';
   	$fallbackChain = $langSettings['fallbacks'] ?? '';
   	if ($fallbackType == 'strict') {
   		$fallbackChain = '';
   	}
   	$fallbackChainArray = array_map( function ( $uid ) {
   		return intval( $uid );
   	}, \nn\t3::Arrays($fallbackChain)->intExplode() );
   	array_unshift( $fallbackChainArray, $langUid );
   	return $fallbackChainArray;
   }
   

