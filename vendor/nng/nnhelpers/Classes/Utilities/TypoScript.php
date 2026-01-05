<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\TypoScript\TypoScriptStringFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Methoden zum Parsen und Konvertieren von TypoScript
 */
class TypoScript implements SingletonInterface
{
	/**
	 * 	TypoScript 'name.'-Syntax in normales Array umwandeln.
	 * 	Erleichtert den Zugriff
	 *	```
	 *	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);
	 *	```
	 * 	@return array
	 */
	public function convertToPlainArray ($ts) {
		if (!$ts || !is_array($ts)) return [];
		$typoscriptService = \nn\t3::injectClass( TypoScriptService::class );
		return $typoscriptService->convertTypoScriptArrayToPlainArray($ts);
	}

	/**
	 * Wandelt einen Text in ein TypoScript-Array um.
	 * ```
	 * $example = '
	 * 	lib.test {
	 * 	  someVal = 10
	 * 	}
	 * ';
	 * \nn\t3::TypoScript()->fromString($example);	=> ['lib'=>['test'=>['someVal'=>10]]]
	 * \nn\t3::TypoScript()->fromString($example, $mergeSetup);	=> ['lib'=>['test'=>['someVal'=>10]]]
	 * ```
	 * @return array
	 */
	public function fromString ( $str = '', $overrideSetup = [] ) {
		if (!trim($str)) return $overrideSetup;
		$typoScriptStringFactory = GeneralUtility::makeInstance( TypoScriptStringFactory::class );
		$rootNode = $typoScriptStringFactory->parseFromStringWithIncludes('nnhelpers-fromstring', $str);
		$setup = $rootNode->toArray();
		if ($overrideSetup) {
			$setup = array_replace_recursive($overrideSetup, $setup);
		}
		return $this->convertToPlainArray($setup);
	}

	/**
	 * Page-Config hinzufügen
	 * Alias zu `\nn\t3::Registry()->addPageConfig( $str );`
	 *
	 * ```
	 * \nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	 * \nn\t3::TypoScript()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	 * \nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );
	 * ```
	 * @return void
	 */
	public function addPageConfig( $str = '' )
	{
		\nn\t3::Registry()->addPageConfig( $str );
	}
}
