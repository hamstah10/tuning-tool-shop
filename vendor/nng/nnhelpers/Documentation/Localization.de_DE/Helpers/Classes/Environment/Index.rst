
.. include:: ../../../Includes.txt

.. _Environment:

==============================================
Environment
==============================================

\\nn\\t3::Environment()
----------------------------------------------

Alles, was man über die Umgebung der Anwendung wissen muss.
Von Sprach-ID des Users, der baseUrl bis zu der Frage, welche Extensions am Start sind.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Environment()->extLoaded(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüfen, ob Extension geladen ist.

.. code-block:: php

	\nn\t3::Environment()->extLoaded('news');

| :ref:`➜ Go to source code of Environment::extLoaded() <Environment-extLoaded>`

\\nn\\t3::Environment()->extPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

absoluten Pfad zu einer Extension holen
z.B. ``/var/www/website/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extPath('extname');

| ``@return string``

| :ref:`➜ Go to source code of Environment::extPath() <Environment-extPath>`

\\nn\\t3::Environment()->extRelPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

relativen Pfad (vom aktuellen Script aus) zu einer Extension holen
z.B. ``../typo3conf/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extRelPath('extname');

| ``@return string``

| :ref:`➜ Go to source code of Environment::extRelPath() <Environment-extRelPath>`

\\nn\\t3::Environment()->getBaseURL();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt die baseUrl (``config.baseURL``) zurück, inkl. http(s) Protokoll z.B. https://www.webseite.de/

.. code-block:: php

	\nn\t3::Environment()->getBaseURL();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getBaseURL() <Environment-getBaseURL>`

\\nn\\t3::Environment()->getCookieDomain(``$loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Die Cookie-Domain holen z.B. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getCookieDomain()

| ``@return string``

| :ref:`➜ Go to source code of Environment::getCookieDomain() <Environment-getCookieDomain>`

\\nn\\t3::Environment()->getCountries(``$lang = 'de', $key = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle im System verfügbaren Ländern holen

.. code-block:: php

	\nn\t3::Environment()->getCountries();

| ``@return array``

| :ref:`➜ Go to source code of Environment::getCountries() <Environment-getCountries>`

\\nn\\t3::Environment()->getCountryByIsocode(``$cn_iso_2 = NULL, $field = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Land aus der Tabelle ``static_countries``
anhand seines Ländercodes (z.B. ``DE``) holen

.. code-block:: php

	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );

| ``@return array``

| :ref:`➜ Go to source code of Environment::getCountryByIsocode() <Environment-getCountryByIsocode>`

\\nn\\t3::Environment()->getDefaultLanguage(``$returnKey = 'typo3Language'``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Environment::getDefaultLanguage() <Environment-getDefaultLanguage>`

\\nn\\t3::Environment()->getDomain();
"""""""""""""""""""""""""""""""""""""""""""""""

Die Domain holen z.B. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getDomain();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getDomain() <Environment-getDomain>`

\\nn\\t3::Environment()->getExtConf(``$ext = 'nnhelpers', $param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Configuration aus ``ext_conf_template.txt`` holen (Backend, Extension Configuration)

.. code-block:: php

	\nn\t3::Environment()->getExtConf('nnhelpers', 'varname');

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.extConf(path:'nnhelper')}
	{nnt3:ts.extConf(path:'nnhelper.varname')}
	{nnt3:ts.extConf(path:'nnhelper', key:'varname')}

| ``@return mixed``

| :ref:`➜ Go to source code of Environment::getExtConf() <Environment-getExtConf>`

\\nn\\t3::Environment()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Die aktuelle Sprache (als Zahl) des Frontends holen.

.. code-block:: php

	\nn\t3::Environment()->getLanguage();

| ``@return int``

| :ref:`➜ Go to source code of Environment::getLanguage() <Environment-getLanguage>`

\\nn\\t3::Environment()->getLanguageFallbackChain(``$langUid = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Environment::getLanguageFallbackChain() <Environment-getLanguageFallbackChain>`

\\nn\\t3::Environment()->getLanguageKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Die aktuelle Sprache (als Kürzel wie "de") im Frontend holen

.. code-block:: php

	\nn\t3::Environment()->getLanguageKey();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getLanguageKey() <Environment-getLanguageKey>`

\\nn\\t3::Environment()->getLanguages(``$key = 'languageId', $value = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt eine Liste aller definierten Sprachen zurück.
Die Sprachen müssen in der YAML site configuration festgelegt sein.

.. code-block:: php

	// [['title'=>'German', 'iso-639-1'=>'de', 'typo3Language'=>'de', ....], ['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages();
	
	// ['de'=>['title'=>'German', 'typo3Language'=>'de'], 'en'=>['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages('iso-639-1');
	
	// ['de'=>0, 'en'=>1]
	\nn\t3::Environment()->getLanguages('iso-639-1', 'languageId');
	
	// [0=>'de', 1=>'en']
	\nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');

Es gibt auch Helper zum Konvertieren von Sprach-IDs in Sprach-Kürzel
und umgekehrt:

.. code-block:: php

	// --> 0
	\nn\t3::Convert('de')->toLanguageId();
	
	// --> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param string $key``
| ``@param string $value``
| ``@return string|array``

| :ref:`➜ Go to source code of Environment::getLanguages() <Environment-getLanguages>`

\\nn\\t3::Environment()->getLocalConf(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konfiguration aus der ``LocalConfiguration.php`` holen

.. code-block:: php

	\nn\t3::Environment()->getLocalConf('FE.cookieName');

| ``@return string``

| :ref:`➜ Go to source code of Environment::getLocalConf() <Environment-getLocalConf>`

\\nn\\t3::Environment()->getPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Absoluten Pfad zum Typo3-Root-Verzeichnis holen. z.B. ``/var/www/website/``

.. code-block:: php

	\nn\t3::Environment()->getPathSite()

früher: ``PATH_site``

| :ref:`➜ Go to source code of Environment::getPathSite() <Environment-getPathSite>`

\\nn\\t3::Environment()->getPostMaxSize();
"""""""""""""""""""""""""""""""""""""""""""""""

Maximale Upload-Größe für Dateien aus dem Frontend zurückgeben.
Diese Angabe ist der Wert, der in der php.ini festgelegt wurde und ggf.
über die .htaccess überschrieben wurde.

.. code-block:: php

	\nn\t3::Environment()->getPostMaxSize();  // z.B. '1048576' bei 1MB

| ``@return integer``

| :ref:`➜ Go to source code of Environment::getPostMaxSize() <Environment-getPostMaxSize>`

\\nn\\t3::Environment()->getPsr4Prefixes();
"""""""""""""""""""""""""""""""""""""""""""""""

Liste der PSR4 Prefixes zurückgeben.

Das ist ein Array mit allen Ordnern, die beim autoloading / Bootstrap von TYPO3 nach Klassen
geparsed werden müssen. In einer TYPO3 Extension ist das per default der Ordern ``Classes``.
Die Liste wird von Composer/TYPO3 generiert.

Zurückgegeben wird ein array. Key ist ``Vendor\Namespace\``, Wert ist ein Array mit Pfaden zu den Ordnern,
die rekursiv nach Klassen durchsucht werden. Es spielt dabei keine Rolle, ob TYPO3 im composer
mode läuft oder nicht.

.. code-block:: php

	\nn\t3::Environment()->getPsr4Prefixes();

Beispiel für Rückgabe:

.. code-block:: php

	[
	    'Nng\Nnhelpers\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnhelpers/Classes', ...],
	    'Nng\Nnrestapi\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnrestapi/Classes', ...]
	]

| ``@return array``

| :ref:`➜ Go to source code of Environment::getPsr4Prefixes() <Environment-getPsr4Prefixes>`

\\nn\\t3::Environment()->getRelPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Relativen Pfad zum Typo3-Root-Verzeichnis holen. z.B. ``../``

.. code-block:: php

	\nn\t3::Environment()->getRelPathSite()

| ``@return string``

| :ref:`➜ Go to source code of Environment::getRelPathSite() <Environment-getRelPathSite>`

\\nn\\t3::Environment()->getRequest();
"""""""""""""""""""""""""""""""""""""""""""""""

Holt den aktuellen Request.
Workaround für Sonderfälle – und den Fall, dass das Core-Team
diese Option nicht in Zukunft selbst implementiert.

.. code-block:: php

	$request = \nn\t3::Environment()->getRequest();

| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Environment::getRequest() <Environment-getRequest>`

\\nn\\t3::Environment()->getSite(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Das aktuelle ``Site`` Object holen.
Über dieses Object kann z.B. ab TYPO3 9 auf die Konfiguration aus der site YAML-Datei zugegriffen werden.

Im Kontext einer MiddleWare ist evtl. die ``site`` noch nicht geparsed / geladen.
In diesem Fall kann der ``$request`` aus der MiddleWare übergeben werden, um die Site zu ermitteln.

Siehe auch ``\nn\t3::Settings()->getSiteConfig()``, um die site-Konfiguration auszulesen.

.. code-block:: php

	\nn\t3::Environment()->getSite();
	\nn\t3::Environment()->getSite( $request );
	
	\nn\t3::Environment()->getSite()->getConfiguration();
	\nn\t3::Environment()->getSite()->getIdentifier();

| ``@return \TYPO3\CMS\Core\Site\Entity\Site``

| :ref:`➜ Go to source code of Environment::getSite() <Environment-getSite>`

\\nn\\t3::Environment()->getSyntheticFrontendRequest(``$pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generiert einen virtuellen Frontend Request, der in jedem Context verwendet werden kann.
Initialisiert auch das Frontend TypoScript-Object und alle relevanten Objekte.

.. code-block:: php

	$request = \nn\t3::Environment()->getSyntheticFrontendRequest();

| ``@param int $pageUid``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Environment::getSyntheticFrontendRequest() <Environment-getSyntheticFrontendRequest>`

\\nn\\t3::Environment()->getVarPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Absoluten Pfad zu dem ``/var``-Verzeichnis von Typo3 holen.

Dieses Verzeichnis speichert temporäre Cache-Dateien.
Je nach Version von Typo3 und Installationstyp (Composer oder Non-Composer mode)
ist dieses Verzeichnis an unterschiedlichen Orten zu finden.

.. code-block:: php

	// /full/path/to/typo3temp/var/
	$path = \nn\t3::Environment()->getVarPath();

| :ref:`➜ Go to source code of Environment::getVarPath() <Environment-getVarPath>`

\\nn\\t3::Environment()->isBackend();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüfen, ob wir uns im Backend-Context befinden

.. code-block:: php

	    \nn\t3::Environment()->isBackend();

| ``@return bool``

| :ref:`➜ Go to source code of Environment::isBackend() <Environment-isBackend>`

\\nn\\t3::Environment()->isFrontend();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüfen, ob wir uns im Frontend-Context befinden

.. code-block:: php

	    \nn\t3::Environment()->isFrontend();

| ``@return bool``

| :ref:`➜ Go to source code of Environment::isFrontend() <Environment-isFrontend>`

\\nn\\t3::Environment()->isHttps();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt ``true`` zurück, wenn die Seite über HTTPS aufgerufen wird.

.. code-block:: php

	$isHttps = \nn\t3::Environment()->isHttps();

| ``@return boolean``

| :ref:`➜ Go to source code of Environment::isHttps() <Environment-isHttps>`

\\nn\\t3::Environment()->isLocalhost();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob Installation auf lokalem Server läuft

.. code-block:: php

	\nn\t3::Environment()->isLocalhost()

| ``@return boolean``

| :ref:`➜ Go to source code of Environment::isLocalhost() <Environment-isLocalhost>`

\\nn\\t3::Environment()->setLanguage(``$languageId = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Die aktuelle Sprache setzen.

Hilfreich, wenn wir die Sprache in einem Context brauchen, wo er nicht initialisiert
wurde, z.B. in einer MiddleWare oder CLI.

.. code-block:: php

	\nn\t3::Environment()->setLanguage(0);

| ``@param int $languageId``
| ``@return self``

| :ref:`➜ Go to source code of Environment::setLanguage() <Environment-setLanguage>`

\\nn\\t3::Environment()->setRequest(``$request``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt den aktuellen Request.
Wird in der ``RequestParser``-MiddleWare gesetzt

.. code-block:: php

	\nn\t3::Environment()->setRequest( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest``
| ``@return self``

| :ref:`➜ Go to source code of Environment::setRequest() <Environment-setRequest>`

\\nn\\t3::Environment()->t3Version();
"""""""""""""""""""""""""""""""""""""""""""""""

Die Version von Typo3 holen, als Ganzzahl, z.b "8"
Alias zu ``\nn\t3::t3Version()``

.. code-block:: php

	\nn\t3::Environment()->t3Version();
	
	if (\nn\t3::t3Version() >= 8) {
	    // nur für >= Typo3 8 LTS
	}

| ``@return int``

| :ref:`➜ Go to source code of Environment::t3Version() <Environment-t3Version>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
