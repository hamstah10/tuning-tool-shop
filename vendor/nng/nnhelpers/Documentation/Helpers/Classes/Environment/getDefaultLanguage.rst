
.. include:: ../../../../Includes.txt

.. _Environment-getDefaultLanguage:

==============================================
Environment::getDefaultLanguage()
==============================================

\\nn\\t3::Environment()->getDefaultLanguage(``$returnKey = 'typo3Language'``);
----------------------------------------------

Returns the default language (Default Language). In TYPO3, this is always the language with ID ``0``
The languages must be defined in the YAML site configuration.

.. code-block:: php

	// 'de'
	\nn\t3::Environment()->getDefaultLanguage();
	
	// 'de-DE'
	\nn\t3::Environment()->getDefaultLanguage('hreflang');
	
	// ['title'=>'German', 'typo3Language'=>'de', ...]
	\nn\t3::Environment()->getDefaultLanguage( true );

| ``@param string|boolean $returnKey``
| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getDefaultLanguage( $returnKey = 'typo3Language' ) {
   	$firstLanguage = $this->getLanguages('languageId')[0] ?? [];
   	if ($returnKey === true) return $firstLanguage;
   	return $firstLanguage[$returnKey] ?? '';
   }
   

