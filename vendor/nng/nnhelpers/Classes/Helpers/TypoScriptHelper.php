<?php
namespace Nng\Nnhelpers\Helpers;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\TypoScript\IncludeTree\SysTemplateRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Frontend\Page\PageInformation;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\VisibilityAspect;

use TYPO3\CMS\Core\TypoScript\FrontendTypoScriptFactory;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;

/**
 * Helper for TypoScript
 *
 * ```
 * $typoScriptHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
 * $typoScriptHelper->getTypoScript( 1 );
 * ```
 *
 * All credits to this script go to Stoppeye on StackOverflow:
 * https://stackoverflow.com/questions/77151557/typo3-templateservice-deprecation-how-to-get-plugin-typoscript-not-in-fe-cont
 *
 */
class TypoScriptHelper
{
	public function __construct(
		private FrontendTypoScriptFactory $frontendTypoScriptFactory,
		#[Autowire(service: 'cache.typoscript')]
		private PhpFrontend $typoScriptCache,
		private SysTemplateRepository $sysTemplateRepository,
	) {}


	/**
	 * Get the TypoScript setup as TypoScript object.
	 *
	 * @param int $pageUid Page UID to get TypoScript for
	 * @return \TYPO3\CMS\Core\TypoScript\FrontendTypoScript
	 */
	public function getTypoScriptObject(?int $pageUid = null): FrontendTypoScript
	{
		if (!$pageUid) {
			$pageUid = \nn\t3::Page()->getPid();
		}

		// make sure, we don't get config from disabled TS templates in BE context
		$context = GeneralUtility::makeInstance(Context::class);
		$visibilityAspect = GeneralUtility::makeInstance(VisibilityAspect::class);
		$context->setAspect('visibility', $visibilityAspect);

		$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageUid);
		if (!$site) {
			throw new \Exception('Site not found for page ID ' . $pageUid);
		}

		$pageInformation = $this->getPageInformation($site, $pageUid);
		$isCachingAllowed = false;
		$conditionMatcherVariables = $this->prepareConditionMatcherVariables($site, $pageInformation);

		$frontendTypoScript = $this->frontendTypoScriptFactory->createSettingsAndSetupConditions(
			$site,
			$pageInformation->getSysTemplateRows(),
			$conditionMatcherVariables,
			$isCachingAllowed ? $this->typoScriptCache : null,
		);

		$ts = $this->frontendTypoScriptFactory->createSetupConfigOrFullSetup(
			true,  // $needsFullSetup -> USER_INT
			$frontendTypoScript,
			$site,
			$pageInformation->getSysTemplateRows(),
			$conditionMatcherVariables,
			'0',  // $type -> typeNum (default: 0; GET/POST param: type)
			$isCachingAllowed ? $this->typoScriptCache : null,
			null,  // $request
		);

		return $ts;
	}

	/**
	 * Get complete TypoScript setup for a given page ID following TYPO3 13 approach.
	 * ```
	 * $typoScriptHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
	 *
	 * // get typoscript for current page
	 * $typoScriptHelper->getTypoScript();
	 *
	 * // get typoscript for page with uid 1
	 * $typoScriptHelper->getTypoScript( 1 );
	 *
	 * ```
	 * @param int $pageUid Page UID to get TypoScript for
	 * @return array Complete TypoScript setup with dot-syntax
	 */
	public function getTypoScript(?int $pageUid = null): array
	{
		$ts = $this->getTypoScriptObject($pageUid);
		$settings = [];

		if ($ts->hasPage() && $ts->hasSetup()) {
			$settings = $ts->getSetupTree()->toArray();
		}

		return $settings;
	}

	/**
	 * Get page information for a given page ID following TYPO3 13 approach.
	 *
	 * @param Site $site Site to get page information for
	 * @param int $pageUid Page UID to get page information for
	 * @return PageInformation Page information for the given page ID
	 */
	protected function getPageInformation(Site $site, int $pageUid): PageInformation
	{
		$pageInformation = new PageInformation();
		$pageInformation->setId($pageUid);

		$pageRecord = \nn\t3::Db()->findByUid('pages', $pageUid) ?: [];
		$pageInformation->setPageRecord($pageRecord);

		// Get the root line
		$rootLine = \nn\t3::Page()->getRootline($pageUid);

		if ($site instanceof Site && $site->isTypoScriptRoot()) {
			$rootLineUntilSite = [];
			foreach ($rootLine as $index => $rootlinePage) {
				$rootLineUntilSite[$index] = $rootlinePage;
				$pageId = (int)($rootlinePage['uid'] ?? 0);
				if ($pageId === $site->getRootPageId()) {
					break;
				}
			}
			$rootLine = $rootLineUntilSite;
		}

		$pageInformation->setRootline($rootLine);
		$sysTemplateRows = $this->sysTemplateRepository->getSysTemplateRowsByRootline($rootLine);
		$pageInformation->setSysTemplateRows($sysTemplateRows);
		$localRootLine = $this->getLocalRootLine($site, $pageInformation);
		$pageInformation->setLocalRootline($localRootLine);

		return $pageInformation;
	}

	/**
	 * Calculate "local" rootLine that stops at first root=1 template.
	 *
	 * @param Site $site Site to get local root line for
	 * @param PageInformation $pageInformation Page information to get local root line for
	 * @return array Local root line
	 */
	protected function getLocalRootLine(Site $site, PageInformation $pageInformation): array
	{
		$sysTemplateRows = $pageInformation->getSysTemplateRows();
		$rootLine = $pageInformation->getRootLine();
		$sysTemplateRowsIndexedByPid = array_combine(array_column($sysTemplateRows, 'pid'), $sysTemplateRows);
		$localRootline = [];
		foreach ($rootLine as $rootlinePage) {
			array_unshift($localRootline, $rootlinePage);
			$pageId = (int)($rootlinePage['uid'] ?? 0);
			if ($pageId === $site->getRootPageId() && $site->isTypoScriptRoot()) {
				break;
			}
			if ($pageId > 0 && (int)($sysTemplateRowsIndexedByPid[$pageId]['root'] ?? 0) === 1) {
				break;
			}
		}
		return $localRootline;
	}

	/**
	 * Data available in TypoScript "condition" matching.
	 *
	 * @param Site $site Site to get condition matcher variables for
	 * @param PageInformation $pageInformation Page information to get condition matcher variables for
	 * @return array Condition matcher variables
	 */
	protected function prepareConditionMatcherVariables(Site $site, PageInformation $pageInformation): array
	{
		$topDownRootLine = $pageInformation->getRootLine();
		$localRootline = $pageInformation->getLocalRootLine();
		ksort($topDownRootLine);

		// Use current request SiteLanguage if available, otherwise fall back to default
		$request = \nn\t3::Environment()->getRequest();
		$language = $request?->getAttribute('language') ?: $site->getDefaultLanguage();

		return [
			'pageId' => $pageInformation->getId(),
			'page' => $pageInformation->getPageRecord(),
			'fullRootLine' => $topDownRootLine,
			'localRootLine' => $localRootline,
			'site' => $site,
			'siteLanguage' => $language,
		];
	}
}
