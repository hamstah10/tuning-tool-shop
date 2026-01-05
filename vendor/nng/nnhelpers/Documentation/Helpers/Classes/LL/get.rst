
.. include:: ../../../../Includes.txt

.. _LL-get:

==============================================
LL::get()
==============================================

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = '', $langKey = NULL, $altLangKey = NULL``);
----------------------------------------------

Get localization for a specific key.

Uses the translations that are specified in the ``xlf`` of an extension.
These files are located by default under ``EXT:extname/Resources/Private/Language/locallang.xlf``
or ``EXT:extname/Resources/Private/Language/en.locallang.xlf`` for the respective translation.

.. code-block:: php

	// Simple example:
	\nn\t3::LL()->get(''LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	
	// Replace arguments in the string: 'After the %s comes the %s' or `Before the %2$s comes the %1$s'
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', ['one', 'two']);
	
	// explode() the result at a separator character
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, ',');
	
	// Translate to a language other than the current frontend language
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, null, 'en');
	\nn\t3::LL()->get('LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier', null, null, null, 'en');

| ``@param string $id``
| ``@param string $extensionName``
| ``@param array $args``
| ``@param string $explode``
| ``@param string $langKey``
| ``@param string $altLangKey``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $id = '',  $extensionName = '', $args = [], $explode = '', $langKey = null, $altLangKey = null ) {
   	$value = LocalizationUtility::translate($id, $extensionName, $args, $langKey, $altLangKey);
   	if (!$explode) return $value;
   	return GeneralUtility::trimExplode(($explode === true ? ',' : $explode), $value);
   }
   

