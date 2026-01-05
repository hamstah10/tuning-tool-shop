
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-parseClass:

==============================================
DocumentationHelper::parseClass()
==============================================

\\nn\\t3::DocumentationHelper()->parseClass(``$className = '', $returnMethods = true``);
----------------------------------------------

Infos zu einer bestimmten Klasse holen.

Ähnelt ``parseFile()`` - allerdings muss hier der eigentliche Klassen-Name übergeben werden.
Wenn man nur den Pfad zur PHP-Datei kennt, nutzt man ``parseFile()``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function parseClass( $className = '', $returnMethods = true )
   {
   	if (!$className || !class_exists($className)) {
   		return [];
   	}
   	$reflector = new \ReflectionClass( $className );
   	$docComment = $reflector->getDocComment();
   	$classComment = MarkdownHelper::parseComment( $docComment );
   	$classInfo = [
   		'className'		=> $className,
   		'comment' 		=> $classComment,
   		'rawComment'	=> $docComment,
   		'methods'		=> [],
   	];
   	if (!$returnMethods) {
   		return $classInfo;
   	}
   	// Durch alle Methoden der Klasse gehen
   	foreach ($reflector->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
   		if ($method->class == $reflector->getName()) {
   			if (strpos($method->name, '__') === false) {
   				$comment = MarkdownHelper::parseComment($method->getDocComment());
   				$params = $method->getParameters();
   				$paramInfo = [];
   				$paramString = [];
   				foreach ($params as $param) {
   					$defaultValue = $param->isOptional() ? $param->getDefaultValue() : '';
   					if (is_string($defaultValue)) $defaultValue = "'{$defaultValue}'";
   					if ($defaultValue === false) $defaultValue = 'false';
   					if ($defaultValue === true) $defaultValue = 'true';
   					if (is_null($defaultValue)) $defaultValue = 'NULL';
   					if ($defaultValue == 'Array' || is_array($defaultValue)) $defaultValue = '[]';
   					$paramInfo[$param->getName()] = $defaultValue;
   					$paramString[] = "\${$param->getName()}" . ($param->isOptional() ? " = {$defaultValue}" : '');
   				}
   				$classInfo['methods'][$method->name] = [
   					'comment' 		=> $comment,
   					'paramInfo'		=> $paramInfo,
   					'paramString'	=> join(', ', $paramString),
   					'sourceCode'	=> self::getSourceCode($method->class, $method->name),
   				];
   			}
   		}
   	}
   	ksort($classInfo['methods']);
   	return $classInfo;
   }
   

