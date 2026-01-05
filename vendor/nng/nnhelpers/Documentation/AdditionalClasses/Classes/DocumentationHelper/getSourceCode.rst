
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-getSourceCode:

==============================================
DocumentationHelper::getSourceCode()
==============================================

\\nn\\t3::DocumentationHelper()->getSourceCode(``$class, $method``);
----------------------------------------------

Get source code of a method.

Returns the "raw" PHP code of the method of a class.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class, 'myMethodName' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function getSourceCode($class, $method)
   {
   	$func = new \ReflectionMethod($class, $method);
   	$f = $func->getFileName();
   	$start_line = $func->getStartLine() - 1;
   	$end_line = $func->getEndLine();
   	$cache = self::$sourceCodeCache[$f] ?? false;
   	if (!$cache) {
   		$source = file($f);
   		$source = implode('', array_slice($source, 0, count($source)));
   		$source = preg_split("/".PHP_EOL."/", $source);
   		self::$sourceCodeCache[$f] = $source;
   	}
   	$source = self::$sourceCodeCache[$f];
   	$body = "\n";
   	for ($i=$start_line; $i<$end_line; $i++) {
   		if ($source[$i] ?? false) {
   			$body.="{$source[$i]}\n";
   		}
   	}
   	$body = str_replace('	', "\t", $body);
   	$body = str_replace("\n\t", "\n", $body);
   	return $body;
   }
   

