
.. include:: ../../../Includes.txt

.. _TranslationHelper:

==============================================
TranslationHelper
==============================================

\\nn\\t3::TranslationHelper()
----------------------------------------------

Übersetzungsmanagement per Deep-L.

Damit diese Funktion nutzbar ist, muss im Extension-Manager von ``nnhelpers`` ein Deep-L Api-Key hinterlegt werden.
Der Key ist ist kostenfrei und erlaubt die Übersetzung von 500.000 Zeichen pro Monat.

.. code-block:: php

	// Übersetzer aktivieren
	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	
	// Übersetzung per Deep-L erlauben
	$translationHelper->setEnableApi( true );
	// Zielsprache festlegen
	$translationHelper->setTargetLanguage( 'EN' );
	
	// Max. Anzahl der Übersetzungen erlauben (zwecks Debugging)
	$translationHelper->setMaxTranslations( 2 );
	
	// Pfad, in dem die l18n-Dateien gespeichert / gecached werden sollen
	$translationHelper->setL18nFolderpath( 'EXT:nnhelpers/Resources/Private/Language/' );
	
	// Übersetzung starten
	$text = $translationHelper->translate('my.example.key', 'Das ist der Text, der übersetzt werden soll');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TranslationHelper()->createKeyHash(``$param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erzeugt einen eindeutigen Hash aus dem Key, der zur Identifizierung eines Textes benötigt wird.
Jeder Text hat in allen Sprachen den gleichen Key.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['mein', 'key', 'array'] );

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::createKeyHash() <TranslationHelper-createKeyHash>`

\\nn\\t3::TranslationHelper()->createTextHash(``$text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erzeugt einen eindeutigen Hash / Checksum aus dem Text.
Der übergebene Text ist immer die Basis-Sprache. Ändert sich der Text in der Basissprache, gibt die Methode eine andere Checksum zurück.
Dadurch wird erkannt, wann ein Text neu übersetzt werden muss. Reine Änderungen an Whitespaces und Tags werden ignoriert.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['mein', 'key', 'array'] );

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::createTextHash() <TranslationHelper-createTextHash>`

\\nn\\t3::TranslationHelper()->getEnableApi();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt zurück, ob die API aktiviert ist.

.. code-block:: php

	$translationHelper->getEnableApi(); // default: false

| ``@return  boolean``

| :ref:`➜ Go to source code of TranslationHelper::getEnableApi() <TranslationHelper-getEnableApi>`

\\nn\\t3::TranslationHelper()->getL18nFolderpath();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den aktuellen Ordner zurück, in dem die Übersetzungs-Dateien gecached werden.
Default ist ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->getL18nFolderpath();

| ``@return  string``

| :ref:`➜ Go to source code of TranslationHelper::getL18nFolderpath() <TranslationHelper-getL18nFolderpath>`

\\nn\\t3::TranslationHelper()->getL18nPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Absoluten Pfad zur l18n-Cache-Datei zurückgeben.
Default ist ``typo3conf/l10n/nnhelpers/[LANG].autotranslated.json``

.. code-block:: php

	$translationHelper->getL18nPath();

| ``@return string``

| :ref:`➜ Go to source code of TranslationHelper::getL18nPath() <TranslationHelper-getL18nPath>`

\\nn\\t3::TranslationHelper()->getMaxTranslations();
"""""""""""""""""""""""""""""""""""""""""""""""

Holt die maximale Anzahl an Übersetzungen, die pro Instanz gemacht werden sollen.

.. code-block:: php

	$translationHelper->getMaxTranslations(); // default: 0 = unendlich

| ``@return integer``

| :ref:`➜ Go to source code of TranslationHelper::getMaxTranslations() <TranslationHelper-getMaxTranslations>`

\\nn\\t3::TranslationHelper()->getTargetLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Holt die Zielsprache für die Übersetzung

.. code-block:: php

	$translationHelper->getTargetLanguage(); // Default: EN

| ``@return  string``

| :ref:`➜ Go to source code of TranslationHelper::getTargetLanguage() <TranslationHelper-getTargetLanguage>`

\\nn\\t3::TranslationHelper()->loadL18nData();
"""""""""""""""""""""""""""""""""""""""""""""""

Komplette Sprach-Datei laden.

.. code-block:: php

	$translationHelper->loadL18nData();

| ``@return array``

| :ref:`➜ Go to source code of TranslationHelper::loadL18nData() <TranslationHelper-loadL18nData>`

\\nn\\t3::TranslationHelper()->saveL18nData(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Komplette Sprach-Datei speichern

.. code-block:: php

	$translationHelper->saveL18nData( $data );

| ``@return boolean``

| :ref:`➜ Go to source code of TranslationHelper::saveL18nData() <TranslationHelper-saveL18nData>`

\\nn\\t3::TranslationHelper()->setEnableApi(``$enableApi``);
"""""""""""""""""""""""""""""""""""""""""""""""

Aktiviert / Deaktiviert die Übersetzung per Deep-L.

.. code-block:: php

	$translationHelper->setEnableApi( true ); // default: false

| ``@param   boolean  $enableApi``
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setEnableApi() <TranslationHelper-setEnableApi>`

\\nn\\t3::TranslationHelper()->setL18nFolderpath(``$l18nFolderpath``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt den aktuellen Ordner, in dem die Übersetzungs-Dateien gecached werden.
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

Setzt die maximale Anzahl an Übersetzungen, die pro Instanz gemacht werden sollen.
Hilft beim Debuggen (damit das Deep-L Kontingent nicht durch Testings ausgeschöpft wird) und bei TimeOuts, wenn viele Texte übersetzt werden müssen.

.. code-block:: php

	$translationHelper->setMaxTranslations( 5 ); // Nach 5 Übersetzungen abbrechen

| ``@param   $maxTranslations``
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setMaxTranslations() <TranslationHelper-setMaxTranslations>`

\\nn\\t3::TranslationHelper()->setTargetLanguage(``$targetLanguage``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt die Zielsprache für die Übersetzung

.. code-block:: php

	$translationHelper->setTargetLanguage( 'FR' );

| ``@param   string  $targetLanguage``  Zielsprache der Übersetzung
| ``@return  self``

| :ref:`➜ Go to source code of TranslationHelper::setTargetLanguage() <TranslationHelper-setTargetLanguage>`

\\nn\\t3::TranslationHelper()->translate(``$key, $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Übersetzen eines Textes.

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
