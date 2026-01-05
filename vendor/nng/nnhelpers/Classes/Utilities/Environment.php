<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;

use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Frontend\Middleware\TypoScriptFrontendInitialization;
use TYPO3\CMS\Frontend\Middleware\PrepareTypoScriptFrontendRendering;
use TYPO3\CMS\Core\Core\ClassLoadingInformation;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Country\CountryProvider;

use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;

/**
 * Alles, was man über die Umgebung der Anwendung wissen muss.
 * Von Sprach-ID des Users, der baseUrl bis zu der Frage, welche Extensions am Start sind.
 */
class Environment implements SingletonInterface
{
	/**
	 * @var boolean
	 */
	public $_isFrontend = null;

	/**
	 * @var
	 */
	public $TYPO3_REQUEST = null;

	/**
	 * @var
	 */
	public $SYNTHETIC_FE_REQUEST = null;

	/**
	 * Setzt den aktuellen Request.
	 * Wird in der `RequestParser`-MiddleWare gesetzt
	 * ```
	 * \nn\t3::Environment()->setRequest( $request );
	 * ```
	 * @param \TYPO3\CMS\Core\Http\ServerRequest
	 * @return self
	 */
	public function setRequest(&$request)
	{
		return $this->TYPO3_REQUEST = $request;
	}

	/**
	 * Holt den aktuellen Request.
	 * Workaround für Sonderfälle – und den Fall, dass das Core-Team
	 * diese Option nicht in Zukunft selbst implementiert.
	 * ```
	 * $request = \nn\t3::Environment()->getRequest();
	 * ```
	 * @return \TYPO3\CMS\Core\Http\ServerRequest
	 */
	public function getRequest()
	{
		$request = $GLOBALS['TYPO3_REQUEST'] ?? null ?: $this->TYPO3_REQUEST;
		if ($request) return $request;

		$request = $this->getSyntheticFrontendRequest();
		return $this->TYPO3_REQUEST = $request;
	}

	/**
	 * Generiert einen virtuellen Frontend Request, der in jedem Context verwendet werden kann.
	 * Initialisiert auch das Frontend TypoScript-Object und alle relevanten Objekte.
	 *
	 * ```
	 * $request = \nn\t3::Environment()->getSyntheticFrontendRequest();
	 * ```
	 * @param int $pageUid
	 * @return \TYPO3\CMS\Core\Http\ServerRequest
	 */
	public function getSyntheticFrontendRequest( $pageUid = null )
	{
		if (isset($this->SYNTHETIC_FE_REQUEST)) {
			return $this->SYNTHETIC_FE_REQUEST;
		}

		// Resolve site + language + a page id (use site root as default)
		$pageUid  = $pageUid ?: (int) (\nn\t3::Page()->getSiteRoot()['uid'] ?? 0);
		$site     = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
		$langId   = $this->getLanguage();
		$language = $site->getLanguageById($langId);

		// Build base URI (fallback if site base is empty)
		$base = (string)$site->getBase();
		if ($base === '' || $base === '/') {
			$base = $this->getBaseURL();
		}
		$uri = new Uri($base);

		// Start request (URI first, then method in v13)
		$queryParams = ['id' => $pageUid]; // make routing happy
		$request = (new ServerRequest($uri, 'GET'))
			->withAttribute('site', $site)
			->withAttribute('language', $language)
			->withQueryParams($queryParams);

		// normalizedParams (what older code used to get from getIndpEnv)
		$serverParams = [
			'HTTP_HOST'      => $uri->getHost() . ($uri->getPort() ? ':' . $uri->getPort() : ''),
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI'    => $uri->getPath() === '' ? '/' : $uri->getPath(),
			'QUERY_STRING'   => http_build_query($queryParams),
			'HTTPS'          => $uri->getScheme() === 'https' ? 'on' : 'off',
			'SERVER_PORT'    => $uri->getPort() ?: ($uri->getScheme() === 'https' ? 443 : 80),
		];
		$normalized = NormalizedParams::createFromServerParams($serverParams);
		$request = $request->withAttribute('normalizedParams', $normalized);

		// routing (PageArguments) — minimal but sufficient
		$pageType = 0;
		$routing  = new PageArguments($pageUid, $pageType, $queryParams);
		$request  = $request->withAttribute('routing', $routing);

		$request = $request->withAttribute(
			'applicationType',
			SystemEnvironmentBuilder::REQUESTTYPE_FE
		);

		// ensure full TypoScript even in "cached" context
		$request = \nn\t3::Tsfe()->softDisableCache($request);

		// Tiny handler to capture the mutated request
		$captured = null;
		$handler = new class($captured) implements RequestHandlerInterface {
			public ?\Psr\Http\Message\ServerRequestInterface $captured;
			public function __construct(&$_c) { $this->captured = &$_c; }
			public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface {
				$this->captured = $request;
				return new HtmlResponse('');
			}
		};

		// needed to prevent cross-contamination when in backend-context
		$oldRequest = $GLOBALS['TYPO3_REQUEST'] ?? null;

		// initialize FE controller (sets frontend.controller / $GLOBALS['TSFE'])
		GeneralUtility::makeInstance(TypoScriptFrontendInitialization::class)->process($request, $handler);
		$request = $handler->captured ?? $request;

		// prepare TypoScript (attaches frontend.typoscript with FULL setup now)
		GeneralUtility::makeInstance(PrepareTypoScriptFrontendRendering::class)->process($request, $handler);
		$request = $handler->captured ?? $request;

		$this->SYNTHETIC_FE_REQUEST = $request;

		// reset to global request before capturing
		$GLOBALS['TYPO3_REQUEST'] = $oldRequest;

		return $request;
	}

	/**
	 * Das aktuelle `Site` Object holen.
	 * Über dieses Object kann z.B. ab TYPO3 9 auf die Konfiguration aus der site YAML-Datei zugegriffen werden.
	 *
	 * Im Kontext einer MiddleWare ist evtl. die `site` noch nicht geparsed / geladen.
	 * In diesem Fall kann der `$request` aus der MiddleWare übergeben werden, um die Site zu ermitteln.
	 *
	 * Siehe auch `\nn\t3::Settings()->getSiteConfig()`, um die site-Konfiguration auszulesen.
	 *
	 * ```
	 * \nn\t3::Environment()->getSite();
	 * \nn\t3::Environment()->getSite( $request );
	 *
	 * \nn\t3::Environment()->getSite()->getConfiguration();
	 * \nn\t3::Environment()->getSite()->getIdentifier();
	 * ```
	 * @return \TYPO3\CMS\Core\Site\Entity\Site
	 */
	public function getSite ( $request = null )
	{
		if (!$request && !\TYPO3\CMS\Core\Core\Environment::isCli()) {
			$request = $this->getRequest();
		}

		// no request set? try getting site by the current pid
		if (!$request) {
			try {
				$pageUid = \nn\t3::Page()->getPid();
				$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
				return $site;
			} catch ( \Exception $e ) {
				return null;
			}
		};

		// try getting site by baseURL
		$site = $request->getAttribute('site');
		if (!$site || is_a($site, \TYPO3\CMS\Core\Site\Entity\NullSite::class)) {
			$matcher = GeneralUtility::makeInstance( SiteMatcher::class );
			$routeResult = $matcher->matchRequest($request);
			$site = $routeResult->getSite();
		}

		// last resort: Just get the first site
		if (!$site || is_a($site, \TYPO3\CMS\Core\Site\Entity\NullSite::class)) {
			$siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
			$sites = $siteFinder->getAllSites();
			$site = reset($sites) ?: null;
		}

		return $site;
	}

	/**
	 * 	Die aktuelle Sprache (als Zahl) des Frontends holen.
	 *	```
	 *	\nn\t3::Environment()->getLanguage();
	 *	```
	 * 	@return int
	 */
	public function getLanguage () {
		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		return $languageAspect->getId();
	}

	/**
	 * Die aktuelle Sprache setzen.
	 *
	 * Hilfreich, wenn wir die Sprache in einem Context brauchen, wo er nicht initialisiert
	 * wurde, z.B. in einer MiddleWare oder CLI.
	 * ```
	 * \nn\t3::Environment()->setLanguage(0);
	 * ```
	 * @param int $languageId
	 * @return self
	 */
	public function setLanguage ( $languageId = 0 )
	{
		$site = $this->getSite();

		try {
			$language = $site->getLanguageById( $languageId );
		} catch (\Exception $e) {
			$language = $site->getDefaultLanguage();
		}

		$languageAspect = LanguageAspectFactory::createFromSiteLanguage($language);
		$context = GeneralUtility::makeInstance(Context::class);
		$context->setAspect('language', $languageAspect);

		// keep the TYPO3_REQUEST in sync with the new language in case other extensions are relying on it
		if ($GLOBALS['TYPO3_REQUEST'] ?? false) {
			$GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']->withAttribute('language', $language);
		}

		// Initialize LanguageService for this language (needed for BackendUtility etc.)
		$languageServiceFactory = GeneralUtility::makeInstance(LanguageServiceFactory::class);
		$GLOBALS['LANG'] = $languageServiceFactory->createFromSiteLanguage($language);

		return $this;
	}

	/**
	 * 	Die aktuelle Sprache (als Kürzel wie "de") im Frontend holen
	 *	```
	 *	\nn\t3::Environment()->getLanguageKey();
	 *	```
	 * 	@return string
	 */
	public function getLanguageKey () {
		$request = $this->getRequest();
		if ($request instanceof ServerRequestInterface) {
			$data = $request->getAttribute('language', null);
			if ($data) {
				return $data->getTwoLetterIsoCode();
			}
		}
		return '';
	}

	/**
	 * Gibt eine Liste aller definierten Sprachen zurück.
	 * Die Sprachen müssen in der YAML site configuration festgelegt sein.
	 *
	 * ```
	 * // [['title'=>'German', 'iso-639-1'=>'de', 'typo3Language'=>'de', ....], ['title'=>'English', 'typo3Language'=>'en', ...]]
	 * \nn\t3::Environment()->getLanguages();
	 *
	 * // ['de'=>['title'=>'German', 'typo3Language'=>'de'], 'en'=>['title'=>'English', 'typo3Language'=>'en', ...]]
	 * \nn\t3::Environment()->getLanguages('iso-639-1');
	 *
	 * // ['de'=>0, 'en'=>1]
	 * \nn\t3::Environment()->getLanguages('iso-639-1', 'languageId');
	 *
	 * // [0=>'de', 1=>'en']
	 * \nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');
	 * ```
	 *
	 * Es gibt auch Helper zum Konvertieren von Sprach-IDs in Sprach-Kürzel
	 * und umgekehrt:
	 *
	 * ```
	 * // --> 0
	 * \nn\t3::Convert('de')->toLanguageId();
	 *
	 * // --> 'de'
	 * \nn\t3::Convert(0)->toLanguage();
	 * ```
	 *
	 * @param string $key
	 * @param string $value
	 * @return string|array
	 */
	public function getLanguages( $key = 'languageId', $value = null )
	{
		$languages = \nn\t3::Settings()->getSiteConfig()['languages'] ?? [];
		array_walk($languages, fn(&$language) => $language['iso-639-1'] = $language['typo3Language'] = $language['iso-639-1'] ?? substr($language['locale'], 0, 2));

		if (!$value) {
			return array_combine( array_column($languages, $key), array_values($languages) );
		}
		return array_combine( array_column($languages, $key), array_column($languages, $value) );
	}

	/**
	 * Gibt die Standard-Sprache (Default Language) zurück. Bei TYPO3 ist das immer die Sprache mit der ID `0`.
	 * Die Sprachen müssen in der YAML site configuration festgelegt sein.
	 *
	 * ```
	 * // 'de'
	 * \nn\t3::Environment()->getDefaultLanguage();
	 *
	 * // 'de-DE'
	 * \nn\t3::Environment()->getDefaultLanguage('hreflang');
	 *
	 * // ['title'=>'German', 'typo3Language'=>'de', ...]
	 * \nn\t3::Environment()->getDefaultLanguage( true );
	 * ```
	 * @param string|boolean $returnKey
	 * @return string|array
	 */
	public function getDefaultLanguage( $returnKey = 'typo3Language' ) {
		$firstLanguage = $this->getLanguages('languageId')[0] ?? [];
		if ($returnKey === true) return $firstLanguage;
		return $firstLanguage[$returnKey] ?? '';
	}

	/**
	 * Gibt eine Liste der Sprachen zurück, die verwendet werden sollen, falls
	 * z.B. eine Seite oder ein Element nicht in der gewünschten Sprache existiert.
	 *
	 * Wichtig: Die Fallback-Chain enthält an erster Stelle die aktuelle bzw. in $langUid
	 * übergebene Sprache.
	 *
	 * ```
	 * // Einstellungen für aktuelle Sprache verwenden (s. Site-Config YAML)
	 * \nn\t3::Environment()->getLanguageFallbackChain();	// --> z.B. [0] oder [1,0]
	 *
	 * // Einstellungen für eine bestimmte Sprache holen
	 * \nn\t3::Environment()->getLanguageFallbackChain( 1 );
	 * // --> [1,0] - falls Fallback in Site-Config definiert wurde und der fallbackMode auf "fallback" steht
	 * // --> [1] - falls es keinen Fallback gibt oder der fallbackMode auf "strict" steht
	 * ```
	 * @param string|boolean $returnKey
	 * @return string|array
	 */
	public function getLanguageFallbackChain( $langUid = true )
	{
		if ($langUid === true) {
			$langUid = $this->getLanguage();
		}

		$langSettings = $this->getLanguages()[$langUid] ?? [];
		$fallbackType = $langSettings['fallbackType'] ?? 'strict';
		$fallbackChain = $langSettings['fallbacks'] ?? '';

		if ($fallbackType == 'strict') {
			$fallbackChain = '';
		}

		$fallbackChainArray = array_map( function ( $uid ) {
			return intval( $uid );
		}, \nn\t3::Arrays($fallbackChain)->intExplode() );
		array_unshift( $fallbackChainArray, $langUid );

		return $fallbackChainArray;
	}

	/**
	 * Gibt `true` zurück, wenn die Seite über HTTPS aufgerufen wird.
	 * ```
	 * $isHttps = \nn\t3::Environment()->isHttps();
	 * ```
	 * @return boolean
	 */
	public function isHttps() {
		return (
			(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
			|| (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
			|| (isset($_SERVER['HTTP_VIA']) && strpos($_SERVER['HTTP_VIA'], 'HTTPS') !== false)
		);
	}

	/**
	 *  Gibt die baseUrl (`config.baseURL`) zurück, inkl. http(s) Protokoll z.B. https://www.webseite.de/
	 *	```
	 *	\nn\t3::Environment()->getBaseURL();
	 *	```
	 * 	@return string
	 */
	public function getBaseURL ()
	{
		$setup = \nn\t3::Settings()->getFullTyposcript();
		if ($baseUrl = $setup['config']['baseURL'] ?? false) return $baseUrl;

		$host = $_SERVER['HTTP_HOST'] ?? '';
		$server = ($this->isHttps() ? 'https' : 'http') . "://{$host}/";
		return $server;
	}

	/**
	 * 	Die Domain holen z.B. www.webseite.de
	 *	```
	 *	\nn\t3::Environment()->getDomain();
	 *	```
	 * 	@return string
	 */
	public function getDomain () {
		$domain = preg_replace('/(http)([s]*)(:)\/\//i', '', $this->getBaseURL());
		return rtrim($domain, '/');
	}

	/**
	 * 	Prüft, ob Installation auf lokalem Server läuft
	 *	```
	 *	\nn\t3::Environment()->isLocalhost()
	 *	```
	 * 	@return boolean
	 */
	public function isLocalhost () {
		$localhost = ['127.0.0.1', '::1'];
		return in_array($_SERVER['REMOTE_ADDR'], $localhost);
	}

	/**
	 * Configuration aus `ext_conf_template.txt` holen (Backend, Extension Configuration)
	 * ```
	 * \nn\t3::Environment()->getExtConf('nnhelpers', 'varname');
	 * ```
	 * Existiert auch als ViewHelper:
	 * ```
	 * {nnt3:ts.extConf(path:'nnhelper')}
	 * {nnt3:ts.extConf(path:'nnhelper.varname')}
	 * {nnt3:ts.extConf(path:'nnhelper', key:'varname')}
	 * ```
	 * @return mixed
	 */
	public function getExtConf ( $ext = 'nnhelpers', $param = '' ) {
		$extConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$ext] ?? [];
		return $param ? ($extConfig[$param] ?? '') : $extConfig;
	}

	/**
	 * 	Konfiguration aus der `LocalConfiguration.php` holen
	 *	```
	 *	\nn\t3::Environment()->getLocalConf('FE.cookieName');
	 *	```
	 * 	@return string
	 */
	public function getLocalConf ( $path = '' ) {
		if (!$path) return $GLOBALS['TYPO3_CONF_VARS'];
		return \nn\t3::Settings()->getFromPath( $path, $GLOBALS['TYPO3_CONF_VARS'] ) ?: '';
	}

	/**
	 * 	Die Cookie-Domain holen z.B. www.webseite.de
	 *	```
	 *	\nn\t3::Environment()->getCookieDomain()
	 *	```
	 * 	@return string
	 */
	public function getCookieDomain ( $loginType = 'FE' ) {
		$cookieDomain = $this->getLocalConf( $loginType . '.cookieDomain' )
			?: $this->getLocalConf( 'SYS.cookieDomain' );

		if (!$cookieDomain) {
			return '';
		}

		// Check if cookieDomain is a regex pattern (starts and ends with /)
		if ($cookieDomain[0] === '/') {
			$host = GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY');
			if (@preg_match($cookieDomain, $host, $match)) {
				$cookieDomain = $match[0];
			} else {
				$cookieDomain = '';
			}
		}

		return $cookieDomain;
	}

	/**
	 * Liste der PSR4 Prefixes zurückgeben.
	 *
	 * Das ist ein Array mit allen Ordnern, die beim autoloading / Bootstrap von TYPO3 nach Klassen
	 * geparsed werden müssen. In einer TYPO3 Extension ist das per default der Ordern `Classes/*`.
	 * Die Liste wird von Composer/TYPO3 generiert.
	 *
	 * Zurückgegeben wird ein array. Key ist `Vendor\Namespace\`, Wert ist ein Array mit Pfaden zu den Ordnern,
	 * die rekursiv nach Klassen durchsucht werden. Es spielt dabei keine Rolle, ob TYPO3 im composer
	 * mode läuft oder nicht.
	 *
	 * ```
	 * \nn\t3::Environment()->getPsr4Prefixes();
	 * ```
	 *
	 * Beispiel für Rückgabe:
	 * ```
	 * [
	 * 	'Nng\Nnhelpers\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnhelpers/Classes', ...],
	 * 	'Nng\Nnrestapi\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnrestapi/Classes', ...]
	 * ]
	 * ```
	 * @return array
	 */
	public function getPsr4Prefixes() {
		$composerClassLoader = ClassLoadingInformation::getClassLoader();
		$psr4prefixes = $composerClassLoader->getPrefixesPsr4();
		return $psr4prefixes;
	}

	/**
	 * Absoluten Pfad zu dem `/var`-Verzeichnis von Typo3 holen.
	 *
	 * Dieses Verzeichnis speichert temporäre Cache-Dateien.
	 * Je nach Version von Typo3 und Installationstyp (Composer oder Non-Composer mode)
	 * ist dieses Verzeichnis an unterschiedlichen Orten zu finden.
	 *
	 * ```
	 * // /full/path/to/typo3temp/var/
	 * $path = \nn\t3::Environment()->getVarPath();
	 * ```
	 */
	public function getVarPath() {
		return rtrim(\TYPO3\CMS\Core\Core\Environment::getVarPath(), '/').'/';
	}

	/**
	 * 	Absoluten Pfad zum Typo3-Root-Verzeichnis holen. z.B. `/var/www/website/`
	 *	```
	 *	\nn\t3::Environment()->getPathSite()
	 *	```
	 * 	früher: `PATH_site`
	 */
	public function getPathSite () {
		return \TYPO3\CMS\Core\Core\Environment::getPublicPath().'/';
	}

	/**
	 * 	Relativen Pfad zum Typo3-Root-Verzeichnis holen. z.B. `../`
	 *	```
	 *	\nn\t3::Environment()->getRelPathSite()
	 *	```
	 * 	@return string
	 */
	public function getRelPathSite () {
		return \nn\t3::File()->relPath();
	}

	/**
	 * 	absoluten Pfad zu einer Extension holen
	 * 	z.B. `/var/www/website/ext/nnsite/`
	 *	```
	 *	\nn\t3::Environment()->extPath('extname');
	 *	```
	 * 	@return string
	 */
	public function extPath ( $extName = '' ) {
		return ExtensionManagementUtility::extPath( $extName );
	}

	/**
	 * 	relativen Pfad (vom aktuellen Script aus) zu einer Extension holen
	 * 	z.B. `../typo3conf/ext/nnsite/`
	 *	```
	 *	\nn\t3::Environment()->extRelPath('extname');
	 *	```
	 *	@return string
	 */
	public function extRelPath ( $extName = '' ) {
		return PathUtility::getRelativePathTo( $this->extPath($extName) );
	}

	/**
	 * 	Prüfen, ob Extension geladen ist.
	 *	```
	 *	\nn\t3::Environment()->extLoaded('news');
	 *	```
	 */
	public function extLoaded ( $extName = '' ) {
		return ExtensionManagementUtility::isLoaded( $extName );
	}

	/**
	 * 	Prüfen, ob wir uns im Frontend-Context befinden
	 *	```
	 * 	\nn\t3::Environment()->isFrontend();
	 *	```
	 * 	@return bool
	 */
	public function isFrontend () {
		if ($this->_isFrontend !== null) {
			return $this->_isFrontend;
		}
		$request = $this->getRequest();
		if ($request instanceof ServerRequestInterface) {
			return $this->_isFrontend = ApplicationType::fromRequest($request)->isFrontend();
		}
		return $this->_isFrontend = false;
	}

	/**
	 * 	Prüfen, ob wir uns im Backend-Context befinden
	 *	```
	 * 	\nn\t3::Environment()->isBackend();
	 *	```
	 * 	@return bool
	 */
	public function isBackend () {
		return !$this->isFrontend();
	}

	/**
	 * Die Version von Typo3 holen, als Ganzzahl, z.b "8"
	 * Alias zu `\nn\t3::t3Version()`
	 * ```
	 * \nn\t3::Environment()->t3Version();
	 *
	 * if (\nn\t3::t3Version() >= 8) {
	 * 	// nur für >= Typo3 8 LTS
	 * }
	 * ```
	 * 	@return int
	 */
	public function t3Version () {
		return \nn\t3::t3Version();
	}

	/**
	 * Alle im System verfügbaren Ländern holen
	 * ```
	 * \nn\t3::Environment()->getCountries();
	 * ```
	 * @return array
	 */
	public function getCountries ( $lang = 'de', $key = 'cn_iso_2' ) {

		if (!ExtensionManagementUtility::isLoaded('static_info_tables')) {
			$countryProvider = GeneralUtility::makeInstance(CountryProvider::class);
			$allCountries = \nn\t3::Convert($countryProvider->getAll())->toArray();
			if ($lang != 'en') {
				$languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->create($lang);
				foreach ($allCountries as &$country) {
					$country['name'] = $languageService->sL($country['localizedNameLabel']);
					$country['officialName'] = $languageService->sL($country['localizedOfficialNameLabel']);
				}
			}
			if ($key != 'cn_iso_2') {
				$results = array_column($allCountries, 'name', 'alpha3IsoCode');
			} else {
				$results = array_combine(
					array_keys($allCountries),
					array_column($allCountries, 'name')
				);
			}

			if (extension_loaded('intl')) {
				$coll = new \Collator('de_DE');
				uasort($results, function($a, $b) use ($coll) {
					return $coll->compare($a, $b);
				});
			} else {
				$oldLocale = setlocale(LC_COLLATE, 0);
				setlocale(LC_COLLATE, 'de_DE.utf8');
				asort($results, SORT_LOCALE_STRING);
				setlocale(LC_COLLATE, $oldLocale);
			}

			return $results;
		}

		$data = \nn\t3::Db()->findAll( 'static_countries' );
		return \nn\t3::Arrays($data)->key($key)->pluck('cn_short_'.$lang)->toArray();
	}

	/**
	 * 	Ein Land aus der Tabelle `static_countries`
	 *	anhand seines Ländercodes (z.B. `DE`) holen
	 *	```
	 *	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	 *	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );
	 *	```
	 * 	@return array
	 */
	public function getCountryByIsocode ( $cn_iso_2 = null, $field = 'cn_iso_2' ) {

		if (!ExtensionManagementUtility::isLoaded('static_info_tables')) {
			$countryProvider = GeneralUtility::makeInstance(CountryProvider::class);
			$allCountries = \nn\t3::Convert($countryProvider->getAll())->toArray();
			if ($field == 'cn_iso_2') {
				return $allCountries[$cn_iso_2] ?? [];
			}
			$allCountriesByIso3 = array_combine(
				array_column($allCountries, 'alpha3IsoCode'),
				array_values($allCountries)
			);
			return $allCountriesByIso3[$cn_iso_2] ?? [];
		}

		$data = \nn\t3::Db()->findByValues( 'static_countries', [$field=>$cn_iso_2] );
		return $data ? array_pop($data) : [];
	}

	/**
	 * Maximale Upload-Größe für Dateien aus dem Frontend zurückgeben.
	 * Diese Angabe ist der Wert, der in der php.ini festgelegt wurde und ggf.
	 * über die .htaccess überschrieben wurde.
	 * ```
	 * \nn\t3::Environment()->getPostMaxSize();  // z.B. '1048576' bei 1MB
	 * ```
	 * @return integer
	 */
	public function getPostMaxSize() {
		$postMaxSize = ini_get('post_max_size');
		return \nn\t3::Convert($postMaxSize)->toBytes();
	}
}
