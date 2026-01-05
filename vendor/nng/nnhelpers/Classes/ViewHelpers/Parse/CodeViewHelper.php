<?php

namespace Nng\Nnhelpers\ViewHelpers\Parse;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Ensures HTML entities inside `<code>` blocks are properly encoded.
 *
 * This is useful when displaying code examples that may contain HTML tags
 * which should be shown as readable code, not rendered as HTML.
 *
 * ```
 * {item.comment->nnt3:parse.code()->f:format.raw()}
 * ```
 *
 * @return string
 */
class CodeViewHelper extends AbstractViewHelper
{
	use CompileWithRenderStatic;

	/**
	 * @var boolean
	 */
	protected $escapeChildren = false;

	/**
	 * @var boolean
	 */
	protected $escapeOutput = false;


	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('str', 'string', 'String containing HTML with <code> blocks', false);
	}

	/**
	 * @return string
	 */
	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
	{
		$str = $arguments['str'] ?? '';

		if (!$str) {
			$str = $renderChildrenClosure();
		}

		if (!is_string($str)) {
			return $str;
		}

		// Encode HTML entities inside <code> blocks
		$str = preg_replace_callback(
			'/<code([^>]*)>(.*?)<\/code>/s',
			function($matches) {
				$attrs = $matches[1];
				$code = $matches[2];
				// Decode any existing entities first, then re-encode for consistency
				$code = html_entity_decode($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');
				$code = htmlspecialchars($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');
				return '<code' . $attrs . '>' . $code . '</code>';
			},
			$str
		);

		return $str;
	}
}
