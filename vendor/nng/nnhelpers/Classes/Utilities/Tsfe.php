<?php

namespace Nng\Nnhelpers\Utilities;

use stdClass;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Frontend\Cache\CacheInstruction;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Context\VisibilityAspect;
use Nng\Nnhelpers\Helpers\TypoScriptHelper;

/**
 * Alles rund um das Typo3 Frontend.
 * Methoden zum Initialisieren des FE aus dem Backend-Context, Zugriff auf das
 * cObj und cObjData etc.
 */
class Tsfe implements SingletonInterface
{
	/**
	 * Cache für das Frontend deaktivieren.
	 *
	 * "Softe" Variante: Nutzt ein fake USER_INT-Objekt, damit bereits gerenderte
	 * Elemente nicht neu gerendert werden müssen. Workaround für TYPO3 v12+, da
	 * TypoScript Setup & Constants nicht mehr initialisiert werden, wenn Seite
	 * vollständig aus dem Cache geladen werden.
	 *
	 * ```
	 * \nn\t3::Tsfe()->softDisableCache()
	 * ```
	 * @param \TYPO3\CMS\Core\Http\ServerRequest $request
	 * @return \TYPO3\CMS\Core\Http\ServerRequest
	 */
	public function softDisableCache( $request = null ): \TYPO3\CMS\Core\Http\ServerRequest
	{
		$request = $request ?: \nn\t3::Environment()->getRequest();
		$cacheInstruction = $request->getAttribute(
			'frontend.cache.instruction',
			new CacheInstruction()
		);
		$cacheInstruction->disableCache('App needs full TypoScript. Cache disabled by \nn\t3::Tsfe()->softDisableCache()');
		$request = $request->withAttribute('frontend.cache.instruction', $cacheInstruction);
		return $request;
	}

	/**
	 * Setzt `config.absRefPrefix` auf die aktuelle URL.
	 *
	 * Damit werden beim Rendern der Links von Content-Elementen
	 * absolute URLs verwendet. Funktioniert zur Zeit (noch) nicht für Bilder.
	 * ```
	 * \nn\t3::Environment()->forceAbsoluteUrls();
	 * $html = \nn\t3::Content()->render(123);
	 * ```
	 */
	public function forceAbsoluteUrls( $enable = true )
	{
		$request = \nn\t3::Environment()->getRequest();

		$fts = $request->getAttribute('frontend.typoscript');
		if (!$fts) return $request;

		$base = rtrim((string)$request->getAttribute('site')->getBase(), '/') . '/';

		$config = $fts->getConfigArray() ?? [];
		$config['absRefPrefix'] = $base;
		$config['forceAbsoluteUrls'] = $enable;

		if (method_exists($fts, 'setConfigArray')) {
			$fts->setConfigArray($config);
			$request = $request->withAttribute('frontend.typoscript', $fts);
		}

		\nn\t3::Environment()->setRequest($request);
		return $request;
	}

	/**
	 * Vollständig initialisiertes TypoScript in den Request einschleusen.
	 *
	 * Dies ist erforderlich, wenn in einem gecachten Frontend-Kontext ausgeführt wird,
	 * in dem das TypoScript-Setup-Array nicht initialisiert ist. Es verwendet den
	 * TypoScriptHelper, um ein vollständiges TypoScript-Objekt zu erstellen und es
	 * in das `frontend.typoscript`-Attribut des Requests einzuschleusen.
	 *
	 * ```
	 * // In der Middleware:
	 * $request = \nn\t3::Tsfe()->injectTypoScript( $request );
	 * ```
	 * @param \TYPO3\CMS\Core\Http\ServerRequest $request
	 * @return \TYPO3\CMS\Core\Http\ServerRequest
	 */
	public function injectTypoScript( $request = null ): \TYPO3\CMS\Core\Http\ServerRequest
	{
		$request = $request ?: \nn\t3::Environment()->getRequest();

		// Check if TypoScript is already fully initialized
		$existingTs = $request->getAttribute('frontend.typoscript');
		if ($existingTs && $existingTs->hasSetup()) {
			try {
				$existingTs->getSetupArray();
				// If no exception, TypoScript is already available
				return $request;
			} catch (\RuntimeException $e) {
				// TypoScript not initialized, continue to inject
			}
		}

		// Create full TypoScript using the helper
		$pageUid = \nn\t3::Page()->getPid() ?: 1;
		$helper = \nn\t3::injectClass( TypoScriptHelper::class );
		$frontendTypoScript = $helper->getTypoScriptObject( $pageUid );

		// Inject the TypoScript into the request
		$request = $request->withAttribute('frontend.typoscript', $frontendTypoScript);

		// Update both the Environment singleton and the TYPO3 global request
		\nn\t3::Environment()->setRequest($request);
		$GLOBALS['TYPO3_REQUEST'] = $request;

		return $request;
	}

	/**
	 * Ausgeblendete (hidden) Inhaltselemente im Frontend holen.
	 * Kann vor dem Rendern verwendet werden.
	 * ```
	 * \nn\t3::Tsfe()->includeHiddenRecords(true, true, true);
	 * $html = \nn\t3::Content()->render(123);
	 * ```
	 * @param bool $includeHidden
	 * @param bool $includeStartEnd
	 * @param bool $includeDeleted
	 * @return void
	 */
	public function includeHiddenRecords($includeHidden = false, $includeStartEnd = false, $includeDeleted = false)
	{
		$context = GeneralUtility::makeInstance(Context::class);

		$current = $context->getAspect('visibility');
		$includeHidden		= $includeHidden || (method_exists($current, 'includesHiddenPages') ? $current->includesHiddenPages() : false);
		$includeDeleted		= $includeDeleted || (method_exists($current, 'includesDeletedRecords') ? $current->includesDeletedRecords() : false);
		$includeStartEnd	= $includeStartEnd || (method_exists($current, 'includesStartEndRecords') ? $current->includesStartEndRecords() : false);

		$context->setAspect(
			'visibility',
			GeneralUtility::makeInstance(
				VisibilityAspect::class,
				$includeHidden,		// pages
				$includeHidden,		// tt_content
				$includeDeleted,
				$includeStartEnd
			)
		);
	}

	/**
	 * $GLOBALS['TSFE'] holen.
	 * Falls nicht vorhanden (weil im BE) initialisieren.
	 * ```
	 * \nn\t3::Tsfe()->get()
	 * \nn\t3::Tsfe()->get()
	 * ```
	 * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	public function get( $pid = null )
	{
		if (!isset($GLOBALS['TSFE'])) $this->init( $pid );
		return $GLOBALS['TSFE'] ?? '';
	}

	/**
	 * $GLOBALS['TSFE']->cObj holen.
	 * ```
	 * // seit TYPO3 12.4 innerhalb eines Controllers:
	 * \nn\t3::Tsfe()->cObj( $this->request  )
	 * ```
	 * @return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public function cObj( $request = null )
	{
		$request = $request ?: \nn\t3::Environment()->getSyntheticFrontendRequest();
		if ($request) {
			if ($cObj = $request->getAttribute('currentContentObject')) {
				return $cObj;
			}
		}

		$cObjRenderer = \nn\t3::injectClass(ContentObjectRenderer::class);
		$cObjRenderer->setRequest( $request );
		return $cObjRenderer;
	}

	/**
	 * 	$GLOBALS['TSFE']->cObj->data holen.
	 *	```
	 *	\nn\t3::Tsfe()->cObjData( $this->request ); => array mit DB-row des aktuellen Content-Elementes
	 *	\nn\t3::Tsfe()->cObjData( $this->request, 'uid' );	=> uid des aktuellen Content-Elements
	 *	```
	 *	@return mixed
	 */
	public function cObjData( $request = null, $var = null )
	{
		if (is_string($request)) {
			$var = $request;
			$request = null;
		}

		if (!$request) {
			$request = \nn\t3::Environment()->getRequest();
		}

		if (!$request) {
			\nn\t3::Exception('
				\nn\t3::Tsfe()->cObjData() needs a $request as first parameter.
				In a Controller-Context use \nn\t3::Tsfe()->cObjData( $this->request ).
				For other contexts see here: https://bit.ly/3s6dzF0');
		}

		$cObj = $this->cObj( $request );
		if (!$cObj) return false;
		return $var ? ($cObj->data[$var] ?? null) : ($cObj->data ?? []);
	}

	/**
	 * Ein TypoScript-Object rendern.
	 * Früher: `$GLOBALS['TSFE']->cObj->cObjGetSingle()`
	 * ```
	 * \nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'bild.jpg', 'file.'=>['maxWidth'=>200]] )
	 * ```
	 */
	public function cObjGetSingle( $type = '', $conf = [] )
	{
		try {
			$content = $this->cObj()->cObjGetSingle( $type, $conf );
			return $content;
		} catch (\Error $e) {
			return 'ERROR: ' . $e->getMessage();
		}
	}

	/**
	 * Das `$GLOBALS['TSFE']` initialisieren.
	 * Dient nur zur Kompatibilität mit älterem Code, das noch `$GLOBALS['TSFE']` verwendet.
	 *
	 * ```
	 * // TypoScript holen auf die 'alte' Art
	 * $pid = \nn\t3::Page()->getPid();
	 * \nn\t3::Tsfe()->init($pid);
	 * $setup = $GLOBALS['TSFE']->tmpl->setup;
	 * ```
	 * @param int $pid
	 * @param int $typeNum
	 * @return void
	 */
	public function init($pid = 0, $typeNum = 0)
	{
		if (isset($GLOBALS['TSFE'])) {
			return;
		}

		$request = \nn\t3::Environment()->getRequest();
		if (!$request) {
			return;
		}
		
		$cObj = $this->cObj( $request );
		$tsfe = $request->getAttribute('frontend.controller');
		if (!$tsfe) {
			return;
		}
		
		$tsfe->cObj = $cObj;

		$fts = $request->getAttribute('frontend.typoscript');
		if ($fts) {
			$tmpl = new stdClass();
			$tmpl->setup  = $fts->getSetupArray();
			$tmpl->config = $fts->getConfigArray();
			$tsfe->tmpl = $tmpl;
		}

		$pageRepository = GeneralUtility::makeInstance(PageRepository::class);
		$tsfe->sys_page = $pageRepository;

		$userSessionManager = \TYPO3\CMS\Core\Session\UserSessionManager::create('FE');
		$userSession = $userSessionManager->createAnonymousSession();
		$tsfe->fe_user = $userSession;

		$GLOBALS['TSFE'] = $tsfe;
	}

	/**
	 * 	Bootstrap Typo3
	 *	```
	 *	\nn\t3::Tsfe()->bootstrap();
	 *	\nn\t3::Tsfe()->bootstrap( ['vendorName'=>'Nng', 'extensionName'=>'Nnhelpers', 'pluginName'=>'Foo'] );
	 *	```
	 */
	public function bootstrap ( $conf = [] )
	{
		$bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
		if (!$conf) {
			$conf = [
				'vendorName'	=> 'Nng',
				'extensionName'	=> 'Nnhelpers',
				'pluginName'	=> 'Foo',
			];
		}
		$bootstrap->initialize($conf);
	}
}
