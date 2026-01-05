
.. include:: ../../../Includes.txt

.. _Cache:

==============================================
Cache
==============================================

\\nn\\t3::Cache()
----------------------------------------------

Methoden, zum Lesen und Schreiben in den TYPO3 Cache.
Nutzt das Caching-Framework von TYPO3, siehe ``EXT:nnhelpers/ext_localconf.php`` für Details

TYPO3 Cache
| ``get( $identifier )`` / ``set( $identifier, $data )``
Caching-Framework (DB oder Dateisystem, je nach TYPO3-Konfiguration).
Mittlere Performance, da auf Datenbank basierend (oder Dateisystem,
je nach TYPO3-Konfiguration).
Bleibt über die Requests aller Clients hinweg erhalten.

RAM Cache per globale Variable
| ``get( $identifier, true )`` / ``set( $identifier, $data, true )``
Speichert Daten in der globalen Variable ``$GLOBALS['nnhelpers_cache']``.
Ideal für Daten, die mehrfach im selben Request abgerufen werden.
Extrem schnell, aber nur während eines Requests nutzbar, wird nach
jedem Request gelöscht.

Statische PHP-Dateien im Dateisystem
| ``read( $identifier )`` / ``write( $identifier, $data )``
Statische PHP-Dateien im Dateisystem (``var/cache/code/nnhelpers/``).
Schnell durch direktes ``require()``.
Bleibt über die Requests aller Clients hinweg erhalten.

In-Memory Cache
| ``getMemCache( $identifier )`` / ``setMemCache( $identifier, $data )``
In-Memory Cache (APCu, Redis, Memcached – je nach Verfügbarkeit).
Für häufig abgerufene Daten und Sessions. Sehr schnell, da RAM-basiert.
Bleibt über die Requests aller Clients hinweg erhalten.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht Caches.
Wird ein ``identifier`` angegeben, dann werden nur die Caches des spezifischen
identifiers gelöscht – sonst ALLE Caches aller Extensions und Seiten.

RAM-Caches
CachingFramework-Caches, die per ``\nn\t3::Cache()->set()`` gesetzt wurde
Datei-Caches, die per ``\nn\t3::Cache()->write()`` gesetzt wurde

.. code-block:: php

	// ALLE Caches löschen – auch die Caches anderer Extensions, der Seiten etc.
	\nn\t3::Cache()->clear();
	
	// Nur die Caches mit einem bestimmten Identifier löschen
	\nn\t3::Cache()->clear('nnhelpers');

| ``@param string $identifier``
| ``@return void``

| :ref:`➜ Go to source code of Cache::clear() <Cache-clear>`

\\nn\\t3::Cache()->clearMemCache(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den MemCache (APCu, Redis, Memcached).
Ohne Identifier wird der gesamte nnhelpers MemCache gelöscht.
Mit Identifier wird nur der spezifische Eintrag gelöscht.

.. code-block:: php

	// Gesamten nnhelpers MemCache löschen
	\nn\t3::Cache()->clearMemCache();
	
	// Nur einen spezifischen Eintrag löschen
	\nn\t3::Cache()->clearMemCache('mein_key');
	
	// Mit Array als Identifier
	\nn\t3::Cache()->clearMemCache(['pid'=>1, 'uid'=>'7']);

| ``@param mixed $identifier``  Optional: String oder Array zum Identifizieren des Cache-Eintrags
| ``@return void``

| :ref:`➜ Go to source code of Cache::clearMemCache() <Cache-clearMemCache>`

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den Seiten-Cache. Alias zu ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 );       // Seiten-Cache für pid=17 löschen
	\nn\t3::Cache()->clearPageCache();           // Cache ALLER Seiten löschen

| ``@param mixed $pid``     pid der Seite, deren Cache gelöscht werden soll oder leer lassen für alle Seite
| ``@return void``

| :ref:`➜ Go to source code of Cache::clearPageCache() <Cache-clearPageCache>`

\\nn\\t3::Cache()->get(``$identifier = '', $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt Inhalt des Typo3-Caches anhand eines Identifiers.
Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.

.. code-block:: php

	\nn\t3::Cache()->get('myid');
	\nn\t3::Cache()->get(['pid'=>1, 'uid'=>'7']);
	\nn\t3::Cache()->get(['func'=>__METHOD__, 'uid'=>'17']);
	\nn\t3::Cache()->get([__METHOD__=>$this->request->getArguments()]);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
| ``@param mixed $useRamCache`` temporärer Cache in $GLOBALS statt Caching-Framework

| ``@return mixed``

| :ref:`➜ Go to source code of Cache::get() <Cache-get>`

\\nn\\t3::Cache()->getIdentifier(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt übergebenen Cache-Identifier in brauchbaren String um.
Kann auch ein Array als Identifier verarbeiten.

| ``@param mixed $indentifier``
| ``@return string``

| :ref:`➜ Go to source code of Cache::getIdentifier() <Cache-getIdentifier>`

\\nn\\t3::Cache()->getMemCache(``$identifier = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt Inhalt aus dem MemCache (APCu, Redis, Memcached) anhand eines Identifiers.
Wählt automatisch das beste verfügbare Backend.

.. code-block:: php

	// Einfache Verwendung mit String-Identifier
	$data = \nn\t3::Cache()->getMemCache('mein_key');
	
	// Mit Array als Identifier
	$data = \nn\t3::Cache()->getMemCache(['pid'=>1, 'uid'=>'7']);
	
	// Typische Verwendung im Controller
	if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	\nn\t3::Cache()->setMemCache('mein_key', $result, 3600);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
| ``@return mixed``

| :ref:`➜ Go to source code of Cache::getMemCache() <Cache-getMemCache>`

\\nn\\t3::Cache()->read(``$identifier``);
"""""""""""""""""""""""""""""""""""""""""""""""

Statischen Datei-Cache lesen.

Liest die PHP-Datei, die per ``\nn\t3::Cache()->write()`` geschrieben wurde.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

Die PHP-Datei ist ein ausführbares PHP-Script mit dem ``return``-Befehl.
Sie speichert den Cache-Inhalt in einem Array.

.. code-block:: php

	<?php
	    return ['_'=>...];

| ``@return string|array``

| :ref:`➜ Go to source code of Cache::read() <Cache-read>`

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Schreibt einen Eintrag in den Typo3-Cache.
Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.

.. code-block:: php

	// Klassische Anwendung im Controller: Cache holen und setzen
	if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	...
	$cache = $this->view->render();
	return \nn\t3::Cache()->set('myid', $cache);

.. code-block:: php

	// RAM-Cache verwenden? TRUE als dritter Parameter setzen
	\nn\t3::Cache()->set('myid', $dataToCache, true);
	
	// Dauer des Cache auf 60 Minuten festlegen
	\nn\t3::Cache()->set('myid', $dataToCache, 3600);
	
	// Als key kann auch ein Array angegeben werden
	\nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);

| ``@param mixed $indentifier`` String oder Array zum Identifizieren des Cache
| ``@param mixed $data``            Daten, die in den Cache geschrieben werden sollen. (String oder Array)
| ``@param mixed $useRamCache`` ``true``: temporärer Cache in $GLOBALS statt Caching-Framework.
| ``integer``: Wie viele Sekunden cachen?

| ``@return mixed``

| :ref:`➜ Go to source code of Cache::set() <Cache-set>`

\\nn\\t3::Cache()->setMemCache(``$identifier = '', $data = NULL, $lifetime = 3600``);
"""""""""""""""""""""""""""""""""""""""""""""""

Schreibt einen Eintrag in den MemCache (APCu, Redis, Memcached).
Wählt automatisch das beste verfügbare Backend.

.. code-block:: php

	// Einfache Verwendung
	\nn\t3::Cache()->setMemCache('mein_key', $daten);
	
	// Mit Ablaufzeit in Sekunden (hier: 1 Stunde)
	\nn\t3::Cache()->setMemCache('mein_key', $daten, 3600);
	
	// Mit Array als Identifier
	\nn\t3::Cache()->setMemCache(['func'=>__METHOD__, 'args'=>$args], $result, 1800);
	
	// Typische Verwendung im Controller
	if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	return \nn\t3::Cache()->setMemCache('mein_key', $result, 3600);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
| ``@param mixed $data``        Daten, die in den Cache geschrieben werden sollen
| ``@param int $lifetime``      Lebensdauer in Sekunden (Standard: 3600)
| ``@return mixed``

| :ref:`➜ Go to source code of Cache::setMemCache() <Cache-setMemCache>`

\\nn\\t3::Cache()->write(``$identifier, $cache``);
"""""""""""""""""""""""""""""""""""""""""""""""

Statischen Datei-Cache schreiben.

Schreibt eine PHP-Datei, die per ``$cache = require('...')`` geladen werden kann.

Angelehnt an viele Core-Funktionen und Extensions (z.B. mask), die statische PHP-Dateien
ins Filesystem legen, um performancelastige Prozesse wie Klassenpfade, Annotation-Parsing etc.
besser zu cachen. Nutzt bewußt nicht die Core-Funktionen, um jeglichen Overhead zu
vermeiden und größtmögliche Kompatibilität bei Core-Updates zu gewährleisten.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

Das Beispiel oben generiert eine PHP-Datei mit diesem Inhalt:

.. code-block:: php

	<?php
	return ['_' => ['a'=>1, 'b'=>2]];

| ``@return string|array``

| :ref:`➜ Go to source code of Cache::write() <Cache-write>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
