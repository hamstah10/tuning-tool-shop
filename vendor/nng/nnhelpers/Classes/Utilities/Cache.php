<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Methoden, zum Lesen und Schreiben in den TYPO3 Cache.
 * Nutzt das Caching-Framework von TYPO3, siehe `EXT:nnhelpers/ext_localconf.php` für Details
 * 
 * __TYPO3 Cache__
 * __`get( $identifier )` / `set( $identifier, $data )`__
 * Caching-Framework (DB oder Dateisystem, je nach TYPO3-Konfiguration).
 * Mittlere Performance, da auf Datenbank basierend (oder Dateisystem,
 * je nach TYPO3-Konfiguration).
 * Bleibt über die Requests aller Clients hinweg erhalten.
 * 
 * __RAM Cache per globale Variable__
 * __`get( $identifier, true )` / `set( $identifier, $data, true )`__
 * Speichert Daten in der globalen Variable `$GLOBALS['nnhelpers_cache']`.
 * Ideal für Daten, die mehrfach im selben Request abgerufen werden. 
 * Extrem schnell, aber nur während eines Requests nutzbar, wird nach
 * jedem Request gelöscht.
 * 
 * __Statische PHP-Dateien im Dateisystem__
 * __`read( $identifier )` / `write( $identifier, $data )`__
 * Statische PHP-Dateien im Dateisystem (`var/cache/code/nnhelpers/`).
 * Schnell durch direktes `require()`.
 * Bleibt über die Requests aller Clients hinweg erhalten.
 * 
 * __In-Memory Cache__
 * __`getMemCache( $identifier )` / `setMemCache( $identifier, $data )`__
 * In-Memory Cache (APCu, Redis, Memcached – je nach Verfügbarkeit).
 * Für häufig abgerufene Daten und Sessions. Sehr schnell, da RAM-basiert.
 * Bleibt über die Requests aller Clients hinweg erhalten.
 *
 */
class Cache extends \Nng\Nnhelpers\Singleton
{
	/**
	 * @var \TYPO3\CMS\Core\Cache\CacheManager
	 */
	protected $cacheManager;

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|null
	 */
	protected $cacheInstance = null;

	/**
	 * @var \TYPO3\CMS\Core\Cache\CacheManager
	 */
	protected $memCacheManager;

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|null
	 */
	protected $memCacheInstance = null;

	/**
	 * Injections
	 *
	 */
	public function __construct()
	{
		$this->cacheManager = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Cache\CacheManager::class );
	}

	/**
	 * Get the cache instance, registering it if necessary.
	 * This prevents errors when cache is accessed before ext_localconf.php runs.
	 *
	 * @return \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|null
	 */
	protected function getCacheInstance()
	{
		if ($this->cacheInstance !== null) {
			return $this->cacheInstance;
		}

		try {
			if (!$this->cacheManager->hasCache('nnhelpers')) {
				$backendOptions = ['defaultLifeTime' => 3600 * 24];
				$backend = new \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend($backendOptions);
				if (is_callable([$backend, 'initializeObject'])) {
					$backend->initializeObject();
				}
				$cache = new \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend('nnhelpers', $backend);
				if (is_callable([$cache, 'initializeObject'])) {
					$cache->initializeObject();
				}
				$this->cacheManager->registerCache($cache, ['pages']);
			}
			$this->cacheInstance = $this->cacheManager->getCache('nnhelpers');
		} catch (\Exception $e) {
			// Cache not available - return null
			return null;
		}

		return $this->cacheInstance;
	}

	/**
	 * Holt die MemCache-Instanz und wählt automatisch das beste verfügbare Backend.
	 * Prüft in dieser Reihenfolge: APCu, Redis, Memcached.
	 * Falls keines verfügbar ist, wird auf SimpleFileBackend zurückgefallen.
	 *
	 * @return \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|null
	 */
	protected function getMemCacheInstance()
	{
		if ($this->memCacheInstance !== null) {
			return $this->memCacheInstance;
		}

		try {
			if (!$this->memCacheManager) {
				$this->memCacheManager = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Cache\CacheManager::class );
			}
			if (!$this->memCacheManager->hasCache('nnhelpers_mem')) {
				$backend = $this->createBestMemCacheBackend();
				if (is_callable([$backend, 'initializeObject'])) {
					$backend->initializeObject();
				}
				$cache = new \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend('nnhelpers_mem', $backend);
				if (is_callable([$cache, 'initializeObject'])) {
					$cache->initializeObject();
				}
				$this->memCacheManager->registerCache($cache);
			}
			$this->memCacheInstance = $this->memCacheManager->getCache('nnhelpers_mem');
		} catch (\Exception $e) {
			return null;
		}

		return $this->memCacheInstance;
	}

	/**
	 * Erstellt das beste verfügbare MemCache-Backend.
	 * Prüft: APCu > Redis > Memcached > SimpleFileBackend (Fallback)
	 *
	 * @return \TYPO3\CMS\Core\Cache\Backend\BackendInterface
	 */
	protected function createBestMemCacheBackend()
	{
		$defaultOptions = ['defaultLifeTime' => 3600];

		// APCu prüfen
		if (extension_loaded('apcu') && ini_get('apc.enabled')) {
			return new \TYPO3\CMS\Core\Cache\Backend\ApcuBackend('production', $defaultOptions);
		}

		// Redis prüfen
		if (extension_loaded('redis')) {
			try {
				$redisOptions = array_merge($defaultOptions, [
					'hostname' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['redis_host'] ?? '127.0.0.1',
					'port' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['redis_port'] ?? 6379,
					'database' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['redis_database'] ?? 0,
				]);
				$backend = new \TYPO3\CMS\Core\Cache\Backend\RedisBackend('production', $redisOptions);
				return $backend;
			} catch (\Exception $e) {
				// Redis nicht erreichbar, weiter zum nächsten
			}
		}

		// Memcached prüfen
		if (extension_loaded('memcached') || extension_loaded('memcache')) {
			try {
				$memcachedOptions = array_merge($defaultOptions, [
					'servers' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['memcached_servers'] ?? [['127.0.0.1', 11211]],
				]);
				$backend = new \TYPO3\CMS\Core\Cache\Backend\MemcachedBackend('production', $memcachedOptions);
				return $backend;
			} catch (\Exception $e) {
				// Memcached nicht erreichbar, weiter zum Fallback
			}
		}

		// Fallback: SimpleFileBackend
		return new \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend('production', $defaultOptions);
	}

	/**
	 * Lädt Inhalt des Typo3-Caches anhand eines Identifiers.
	 * Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.
	 * ```
	 * \nn\t3::Cache()->get('myid');
	 * \nn\t3::Cache()->get(['pid'=>1, 'uid'=>'7']);
	 * \nn\t3::Cache()->get(['func'=>__METHOD__, 'uid'=>'17']);
	 * \nn\t3::Cache()->get([__METHOD__=>$this->request->getArguments()]);
	 * ```
	 *
	 * @param mixed $identifier	String oder Array zum Identifizieren des Cache
	 * @param mixed $useRamCache	temporärer Cache in $GLOBALS statt Caching-Framework
	 *
	 * @return mixed
	 */
	public function get( $identifier = '', $useRamCache = false )
	{
		$identifier = self::getIdentifier( $identifier );

		// Ram-Cache verwenden? Einfache globale.
		if ($useRamCache && ($cache = $GLOBALS['nnhelpers_cache'][$identifier] ?? false)) {
			return $cache;
		}

		$cacheUtility = $this->getCacheInstance();
		if (!$cacheUtility) {
			return false;
		}
		if ($data = $cacheUtility->get($identifier)) {
			$data = json_decode( $cacheUtility->get($identifier), true );
			if ($data['content'] && $data['expires'] < time()) return false;
			return $data['content'] ?: false;
		}
		return false;
	}

	/**
	 * Schreibt einen Eintrag in den Typo3-Cache.
	 * Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.
	 * ```
	 * // Klassische Anwendung im Controller: Cache holen und setzen
	 * if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	 * ...
	 * $cache = $this->view->render();
	 * return \nn\t3::Cache()->set('myid', $cache);
	 * ```
	 *
	 * ```
	 * // RAM-Cache verwenden? TRUE als dritter Parameter setzen
	 * \nn\t3::Cache()->set('myid', $dataToCache, true);
	 *
	 * // Dauer des Cache auf 60 Minuten festlegen
	 * \nn\t3::Cache()->set('myid', $dataToCache, 3600);
	 *
	 * // Als key kann auch ein Array angegeben werden
	 * \nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);
	 * ````
	 * @param mixed $indentifier	String oder Array zum Identifizieren des Cache
	 * @param mixed $data			Daten, die in den Cache geschrieben werden sollen. (String oder Array)
	 * @param mixed $useRamCache	`true`: temporärer Cache in $GLOBALS statt Caching-Framework.
	 * 								`integer`: Wie viele Sekunden cachen?
	 *
	 * @return mixed
	 */
	public function set( $identifier = '', $data = null, $useRamCache = false )
	{
		$identifier = self::getIdentifier( $identifier );
		$lifetime = 86400;

		if ($useRamCache === true) {
			if (!isset($GLOBALS['nnhelpers_cache'])) {
				$GLOBALS['nnhelpers_cache'] = [];
			}
			return $GLOBALS['nnhelpers_cache'][$identifier] = $data;
		} else if ( $useRamCache !== false ) {
			$lifetime = intval($useRamCache);
		}

		$expires = time() + $lifetime;

		$cacheUtility = $this->getCacheInstance();
		if (!$cacheUtility) {
			return $data;
		}
		$serializedData = json_encode(['content'=>$data, 'expires'=>$expires]);
		$cacheUtility->set($identifier, $serializedData, [], $lifetime);
		return $data;
	}

	/**
	 * Wandelt übergebenen Cache-Identifier in brauchbaren String um.
	 * Kann auch ein Array als Identifier verarbeiten.
	 *
	 * @param mixed $indentifier
	 * @return string
	 */
	public static function getIdentifier( $identifier = null )
	{
		if (is_array($identifier)) {
			$identifier = json_encode($identifier);
		}
		return md5($identifier);
	}

	/**
	 * Löscht den Seiten-Cache. Alias zu `\nn\t3::Page()->clearCache()`
	 * ```
	 * \nn\t3::Cache()->clearPageCache( 17 );		// Seiten-Cache für pid=17 löschen
	 * \nn\t3::Cache()->clearPageCache();			// Cache ALLER Seiten löschen
	 * ```
	 *
	 * @param mixed $pid 	pid der Seite, deren Cache gelöscht werden soll oder leer lassen für alle Seite
	 * @return void
	 */
	public function clearPageCache( $pid = null )
	{
		return \nn\t3::Page()->clearCache( $pid );
	}

	/**
	 * Löscht Caches.
	 * Wird ein `identifier` angegeben, dann werden nur die Caches des spezifischen
	 * identifiers gelöscht – sonst ALLE Caches aller Extensions und Seiten.
	 *
	 * - RAM-Caches
	 * - CachingFramework-Caches, die per `\nn\t3::Cache()->set()` gesetzt wurde
	 * - Datei-Caches, die per `\nn\t3::Cache()->write()` gesetzt wurde
	 *
	 * ```
	 * // ALLE Caches löschen – auch die Caches anderer Extensions, der Seiten etc.
	 * \nn\t3::Cache()->clear();
	 *
	 * // Nur die Caches mit einem bestimmten Identifier löschen
	 * \nn\t3::Cache()->clear('nnhelpers');
	 * ```
	 *
	 * @param string $identifier
	 * @return void
	 */
	public function clear( $identifier = null )
	{

		if (!$identifier) {
			// ALLE TYPO3 Caches löschen, der über das CachingFramework registriert wurde
			$this->cacheManager->flushCaches();
		} else {
			// Spezifischen Cache löschen
			if ($cacheUtility = $this->cacheManager->getCache( $identifier )) {
				$cacheUtility->flush();
			}
		}

		if (!$identifier || $identifier == 'nnhelpers') {
			// RAM Cache löschen
			$GLOBALS['nnhelpers_cache'] = [];

			// File-Cache löschen
			$cacheDir = \nn\t3::Environment()->getVarPath() . "/cache/code/nnhelpers";
			if (is_dir($cacheDir)) {
				$iterator = new \DirectoryIterator($cacheDir);
				foreach ($iterator as $file) {
					if ($file->isFile() && $file->getExtension() === 'php') {
						unlink($file->getPathname());
					}
				}
			}
		}
	}

	/**
	 * Statischen Datei-Cache schreiben.
	 *
	 * Schreibt eine PHP-Datei, die per `$cache = require('...')` geladen werden kann.
	 *
	 * Angelehnt an viele Core-Funktionen und Extensions (z.B. mask), die statische PHP-Dateien
	 * ins Filesystem legen, um performancelastige Prozesse wie Klassenpfade, Annotation-Parsing etc.
	 * besser zu cachen. Nutzt bewußt __nicht__ die Core-Funktionen, um jeglichen Overhead zu
	 * vermeiden und größtmögliche Kompatibilität bei Core-Updates zu gewährleisten.
	 *
	 * ```
	 * $cache = ['a'=>1, 'b'=>2];
	 * $identifier = 'myid';
	 *
	 * \nn\t3::Cache()->write( $identifier, $cache );
	 * $read = \nn\t3::Cache()->read( $identifier );
	 * ```
	 * Das Beispiel oben generiert eine PHP-Datei mit diesem Inhalt:
	 * ```
	 * <?php
	 * return ['_' => ['a'=>1, 'b'=>2]];
	 * ```
	 *
	 * @return string|array
	 */
	public function write( $identifier, $cache )
	{
		$this->set( $identifier, $cache, true );

		$identifier = self::getIdentifier( $identifier );
		$phpCode = '<?php return ' . var_export(['_' => $cache], true) . ';';

		$path = \nn\t3::Environment()->getVarPath() . "cache/code/nnhelpers/{$identifier}.php";
		\TYPO3\CMS\Core\Utility\GeneralUtility::writeFileToTypo3tempDir( $path, $phpCode );

		return $cache;
	}

	/**
	 * Statischen Datei-Cache lesen.
	 *
	 * Liest die PHP-Datei, die per `\nn\t3::Cache()->write()` geschrieben wurde.
	 * ```
	 * $cache = \nn\t3::Cache()->read( $identifier );
	 * ```
	 * Die PHP-Datei ist ein ausführbares PHP-Script mit dem `return`-Befehl.
	 * Sie speichert den Cache-Inhalt in einem Array.
	 * ```
	 * <?php
	 * 	return ['_'=>...];
	 * ```
	 *
	 * @return string|array
	 */
	public function read( $identifier )
	{
		if ($cache = $this->get( $identifier, true )) return $cache;
		$identifier = self::getIdentifier( $identifier );

		$path = \nn\t3::Environment()->getVarPath() . "/cache/code/nnhelpers/{$identifier}.php";

		if (!file_exists($path)) {
			return null;
		}

		$cache = require( $path );
		return $cache['_'];
	}

	/**
	 * Lädt Inhalt aus dem MemCache (APCu, Redis, Memcached) anhand eines Identifiers.
	 * Wählt automatisch das beste verfügbare Backend.
	 * ```
	 * // Einfache Verwendung mit String-Identifier
	 * $data = \nn\t3::Cache()->getMemCache('mein_key');
	 *
	 * // Mit Array als Identifier
	 * $data = \nn\t3::Cache()->getMemCache(['pid'=>1, 'uid'=>'7']);
	 *
	 * // Typische Verwendung im Controller
	 * if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	 *     return $cache;
	 * }
	 * $result = $this->expensiveOperation();
	 * \nn\t3::Cache()->setMemCache('mein_key', $result, 3600);
	 * ```
	 *
	 * @param mixed $identifier	String oder Array zum Identifizieren des Cache
	 * @return mixed
	 */
	public function getMemCache( $identifier = '' )
	{
		$identifier = self::getIdentifier( $identifier );

		$cacheUtility = $this->getMemCacheInstance();
		if (!$cacheUtility) {
			return false;
		}

		if ($data = $cacheUtility->get($identifier)) {
			$data = json_decode( $data, true );
			if ($data['content'] && $data['expires'] < time()) return false;
			return $data['content'] ?: false;
		}
		return false;
	}

	/**
	 * Schreibt einen Eintrag in den MemCache (APCu, Redis, Memcached).
	 * Wählt automatisch das beste verfügbare Backend.
	 * ```
	 * // Einfache Verwendung
	 * \nn\t3::Cache()->setMemCache('mein_key', $daten);
	 *
	 * // Mit Ablaufzeit in Sekunden (hier: 1 Stunde)
	 * \nn\t3::Cache()->setMemCache('mein_key', $daten, 3600);
	 *
	 * // Mit Array als Identifier
	 * \nn\t3::Cache()->setMemCache(['func'=>__METHOD__, 'args'=>$args], $result, 1800);
	 *
	 * // Typische Verwendung im Controller
	 * if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	 *     return $cache;
	 * }
	 * $result = $this->expensiveOperation();
	 * return \nn\t3::Cache()->setMemCache('mein_key', $result, 3600);
	 * ```
	 *
	 * @param mixed $identifier	String oder Array zum Identifizieren des Cache
	 * @param mixed $data		Daten, die in den Cache geschrieben werden sollen
	 * @param int $lifetime		Lebensdauer in Sekunden (Standard: 3600)
	 * @return mixed
	 */
	public function setMemCache( $identifier = '', $data = null, $lifetime = 3600 )
	{
		$identifier = self::getIdentifier( $identifier );

		$expires = time() + $lifetime;

		$cacheUtility = $this->getMemCacheInstance();
		if (!$cacheUtility) {
			return $data;
		}

		$serializedData = json_encode(['content'=>$data, 'expires'=>$expires]);
		$cacheUtility->set($identifier, $serializedData, [], $lifetime);
		return $data;
	}

	/**
	 * Löscht den MemCache (APCu, Redis, Memcached).
	 * Ohne Identifier wird der gesamte nnhelpers MemCache gelöscht.
	 * Mit Identifier wird nur der spezifische Eintrag gelöscht.
	 * ```
	 * // Gesamten nnhelpers MemCache löschen
	 * \nn\t3::Cache()->clearMemCache();
	 *
	 * // Nur einen spezifischen Eintrag löschen
	 * \nn\t3::Cache()->clearMemCache('mein_key');
	 *
	 * // Mit Array als Identifier
	 * \nn\t3::Cache()->clearMemCache(['pid'=>1, 'uid'=>'7']);
	 * ```
	 *
	 * @param mixed $identifier	Optional: String oder Array zum Identifizieren des Cache-Eintrags
	 * @return void
	 */
	public function clearMemCache( $identifier = null )
	{
		$cacheUtility = $this->getMemCacheInstance();
		if (!$cacheUtility) {
			return;
		}

		if ($identifier === null) {
			$cacheUtility->flush();
		} else {
			$identifier = self::getIdentifier( $identifier );
			$cacheUtility->remove($identifier);
		}
	}

}
