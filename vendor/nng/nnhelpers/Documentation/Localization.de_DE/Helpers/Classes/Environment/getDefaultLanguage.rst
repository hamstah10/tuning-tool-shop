
.. include:: ../../../../Includes.txt

.. _Environment-getDefaultLanguage:

==============================================
Environment::getDefaultLanguage()
==============================================

\\nn\\t3::Environment()->getDefaultLanguage(``$returnKey = 'typo3Language'``);
----------------------------------------------

Gibt die Standard-Sprache (Default Language) zurück. Bei TYPO3 ist das immer die Sprache mit der ID ``0``.
Die Sprachen müssen in der YAML site configuration festgelegt sein.

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
   

