
.. include:: ../../../Includes.txt

.. _TranslationHelper:

==============================================
TranslationHelper
==============================================

\\nn\\t3::TranslationHelper()
----------------------------------------------

Translation management via Deep-L.

In order to use this function, a Deep-L API key must be stored in the ``nnhelpers`` extension manager.
The key is free of charge and allows the translation of 500,000 characters per month.

.. code-block:: php

	// Activate translator
	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	
	// Allow translation via Deep-L
	$translationHelper->setEnableApi( true );
	// Set target language
	$translationHelper->setTargetLanguage( 'EN' );
	
	// Allow max. Allow max. number of translations (for debugging purposes)
	$translationHelper->setMaxTranslations( 2 );
	
	// Path in which the l18n files should be saved / cached
	$translationHelper->setL18nFolderpath( 'EXT:nnhelpers/Resources/Private/Language/' );
	
	// Start translation
	$text = $translationHelper->translate('my.example.key', 'This is the text to be translated');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TranslationHelper()->createKeyHash(``$param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generates a unique hash from the key that is required to identify a text.
Each text has the same key in all languages.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::createKeyHash() <TranslationHelper-createKeyHash>`

\\nn\\t3::TranslationHelper()->createTextHash(``$text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generates a unique hash / checksum from the text.
The transferred text is always the base language. If the text in the base language changes, the method returns a different checksum.
This recognizes when a text needs to be retranslated. Pure changes to whitespaces and tags are ignored.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::createTextHash() <TranslationHelper-createTextHash>`

\\nn\\t3::TranslationHelper()->getEnableApi();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns whether the API is enabled.

.. code-block:: php

	$translationHelper->getEnableApi(); // default: false

| ``@return boolean``

| :ref:`➜ Go to source code of TranslationHelper::getEnableApi() <TranslationHelper-getEnableApi>`

\\nn\\t3::TranslationHelper()->getL18nFolderpath();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the current folder in which the translation files are cached.
Default is ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->getL18nFolderpath();

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::getL18nFolderpath() <TranslationHelper-getL18nFolderpath>`

\\nn\\t3::TranslationHelper()->getL18nPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Return the absolute path to the l18n cache file.
Default is ``typo3conf/l10n/nnhelpers/[LANG].autotranslated.json``

.. code-block:: php

	$translationHelper->getL18nPath();

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::getL18nPath() <TranslationHelper-getL18nPath>`

\\nn\\t3::TranslationHelper()->getMaxTranslations();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the maximum number of translations to be made per instance.

.. code-block:: php

	$translationHelper->getMaxTranslations(); // default: 0 = infinite

| ``@return integer``

| :ref:`➜ Go to source code of TranslationHelper::getMaxTranslations() <TranslationHelper-getMaxTranslations>`

\\nn\\t3::TranslationHelper()->getTargetLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the target language for the translation

.. code-block:: php

	$translationHelper->getTargetLanguage(); // Default: EN

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::getTargetLanguage() <TranslationHelper-getTargetLanguage>`

\\nn\\t3::TranslationHelper()->loadL18nData();
"""""""""""""""""""""""""""""""""""""""""""""""

Load complete language file.

.. code-block:: php

	$translationHelper->loadL18nData();

| ``@return array``

| :ref:`➜ Go to source code of TranslationHelper::loadL18nData() <TranslationHelper-loadL18nData>`

\\nn\\t3::TranslationHelper()->saveL18nData(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Save complete language file

.. code-block:: php

	$translationHelper->saveL18nData( $data );

| ``@return boolean``

| :ref:`➜ Go to source code of TranslationHelper::saveL18nData() <TranslationHelper-saveL18nData>`

\\nn\\t3::TranslationHelper()->setEnableApi(``$enableApi``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Aktiviert / Deaktiviert die Übersetzung per Deep-L.

.. code-block:: php

	$translationHelper->setEnableApi( true ); // default: false

| ``@param   boolean  $enableApi``
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setEnableApi() <TranslationHelper-setEnableApi>`

\\nn\\t3::TranslationHelper()->setL18nFolderpath(``$l18nFolderpath``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Setzt den aktuellen Ordner, in dem die Übersetzungs-Dateien gecached werden.
Idee ist es, die übersetzten Texte für Backend-Module nur 1x zu übersetzen und dann in dem Extension-Ordner zu speichern.
Von dort werden sie dann ins GIT deployed.

Default ist ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->setL18nFolderpath('EXT:myext/Resources/Private/Language/');

| ``@param   string  $l``18nFolderpath  Pfad zum Ordner mit den Übersetzungsdateien (JSON)
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setL18nFolderpath() <TranslationHelper-setL18nFolderpath>`

\\nn\\t3::TranslationHelper()->setMaxTranslations(``$maxTranslations``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Setzt die maximale Anzahl an Übersetzungen, die pro Instanz gemacht werden sollen.
Hilft beim Debuggen (damit das Deep-L Kontingent nicht durch Testings ausgeschöpft wird) und bei TimeOuts, wenn viele Texte übersetzt werden müssen.

.. code-block:: php

	$translationHelper->setMaxTranslations( 5 ); // Nach 5 Übersetzungen abbrechen

| ``@param   $maxTranslations``
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setMaxTranslations() <TranslationHelper-setMaxTranslations>`

\\nn\\t3::TranslationHelper()->setTargetLanguage(``$targetLanguage``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Setzt die Zielsprache für die Übersetzung

.. code-block:: php

	$translationHelper->setTargetLanguage( 'FR' );

| ``@param   string  $targetLanguage``  Zielsprache der Übersetzung
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setTargetLanguage() <TranslationHelper-setTargetLanguage>`

\\nn\\t3::TranslationHelper()->translate(``$key, $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Übersetzen eines Textes.

.. code-block:: php

	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	$translationHelper->setEnableApi( true );
	$translationHelper->setTargetLanguage( 'EN' );
	$text = $translationHelper->translate('my.example.key', 'Das ist der Text, der übersetzt werden soll');

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::translate() <TranslationHelper-translate>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
