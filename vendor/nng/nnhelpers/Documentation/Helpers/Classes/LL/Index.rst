
.. include:: ../../../Includes.txt

.. _LL:

==============================================
LL
==============================================

\\nn\\t3::LL()
----------------------------------------------

Wrapper for methods around the localization of Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = '', $langKey = NULL, $altLangKey = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of LL::get() <LL-get>`

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE', $apiKey = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Translates a text via DeepL.
An API key must be entered in the Extension Manager.
DeepL allows the translation of up to 500,000 characters / month free of charge.

.. code-block:: php

	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 1 );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN', 'DE' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 1, 0 );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN', 'DE', $apiKey );

| ``@param string $srcText`` Text to be translated
| ``@param string|int $targetLanguageKey`` Target language (e.g. 'EN' or '1')
| ``@param string|int $sourceLanguageKey`` Source language (e.g. 'DE' or '0')
| ``@param string $apiKey`` DeepL Api key (if not defined in the ExtensionManager)
| ``@return string``

| :ref:`➜ Go to source code of LL::translate() <LL-translate>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
