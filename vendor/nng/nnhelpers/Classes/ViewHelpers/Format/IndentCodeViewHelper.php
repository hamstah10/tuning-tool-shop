<?php

namespace Nng\Nnhelpers\ViewHelpers\Format;

use Nng\Nnhelpers\ViewHelpers\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Fügt eine Einrückung (Indentation) zu jeder Zeile eines Code-Blocks hinzu.
 * Wird für die Sphinx-Dokumentation verwendet, um Code innerhalb von `.. code-block::` korrekt einzurücken.
 * ```
 * {sourceCode->nnt3:format.indentCode(spaces: 3)}
 * ```
 * @return string
 */
class IndentCodeViewHelper extends AbstractViewHelper
{
	protected $escapingInterceptorEnabled = false;

	public function initializeArguments()
	{
		$this->registerArgument('code', 'string', 'Der Code, der eingerückt werden soll', false);
		$this->registerArgument('spaces', 'integer', 'Anzahl der Leerzeichen für die Einrückung', false, 3);
	}

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext )
	{
		$code = $arguments['code'] ?: $renderChildrenClosure();
		$spaces = $arguments['spaces'] ?? 3;

		if (empty($code)) {
			return '';
		}

		$indent = str_repeat(' ', $spaces);
		$lines = explode("\n", $code);
		$indentedLines = array_map(function($line) use ($indent) {
			return $indent . $line;
		}, $lines);

		return implode("\n", $indentedLines);
	}
}
