
.. include:: ../../../../Includes.txt

.. _LL-get:

==============================================
LL::get()
==============================================

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = '', $langKey = NULL, $altLangKey = NULL``);
----------------------------------------------

Localization für einen bestimmten Key holen.

Verwendet die Übersetzungen, die im ``xlf`` einer Extension angegeben sind.
Diese Dateien liegen standardmäßig unter ``EXT:extname/Resources/Private/Language/locallang.xlf``
bzw. ``EXT:extname/Resources/Private/Language/de.locallang.xlf`` für die jeweilige Übersetzung.

.. code-block:: php

	// Einfaches Beispiel:
	\nn\t3::LL()->get(''LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	
	// Argumente im String ersetzen: 'Nach der %s kommt die %s' oder `Vor der %2$s kommt die %1$s'
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', ['eins', 'zwei']);
	
	// explode() des Ergebnisses an einem Trennzeichen
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, ',');
	
	// In andere Sprache als aktuelle Frontend-Sprache übersetzen
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
   

