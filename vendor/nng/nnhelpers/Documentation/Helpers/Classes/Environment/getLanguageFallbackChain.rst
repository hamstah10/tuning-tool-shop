
.. include:: ../../../../Includes.txt

.. _Environment-getLanguageFallbackChain:

==============================================
Environment::getLanguageFallbackChain()
==============================================

\\nn\\t3::Environment()->getLanguageFallbackChain(``$langUid = true``);
----------------------------------------------

Returns a list of the languages that should be used if, for example
e.g. a page or element does not exist in the desired language.

Important: The fallback chain contains in the first place the current or in $langUid
transferred language.

.. code-block:: php

	// Use settings for current language (see Site-Config YAML)
	\nn\t3::Environment()->getLanguageFallbackChain(); // --> e.g. [0] or [1,0]
	
	// Get settings for a specific language
	\nn\t3::Environment()->getLanguageFallbackChain( 1 );
	// --> [1,0] - if fallback was defined in Site-Config and the fallbackMode is set to "fallback"
	// --> [1] - if there is no fallback or the fallbackMode is set to "strict"

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
   

