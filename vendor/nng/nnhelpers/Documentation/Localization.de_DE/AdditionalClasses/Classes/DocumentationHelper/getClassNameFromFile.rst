
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-getClassNameFromFile:

==============================================
DocumentationHelper::getClassNameFromFile()
==============================================

\\nn\\t3::DocumentationHelper()->getClassNameFromFile(``$file``);
----------------------------------------------

Klassen-Name als String inkl. vollem Namespace aus einer PHP-Datei holen.
Gibt z.B. ``Nng\Classes\MyClass`` zurück.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::getClassNameFromFile( 'Classes/MyClass.php' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function getClassNameFromFile( $file )
   {
   	$file = \nn\t3::File()->absPath( $file );
   	$fileStr = php_strip_whitespace($file);
   	$tokens = @token_get_all($fileStr);
   	$namespace = $class = '';
   	for ($i = 0; $i<count($tokens); $i++) {
   		if ($tokens[$i][0] === T_NAMESPACE) {
   			for ($j=$i+1;$j<count($tokens); $j++) {
   				if ($tokens[$j][0] === T_STRING || (PHP_VERSION_ID >= 80000 && ($tokens[$j][0] == T_NAME_QUALIFIED || $tokens[$j][0] == T_NAME_FULLY_QUALIFIED))) {
   					$namespace .= '\\'.$tokens[$j][1];
   				} else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
   					break;
   				}
   			}
   		}
   		if ($tokens[$i][0] === T_CLASS) {
   			for ($j=$i+1;$j<count($tokens);$j++) {
   				if ($tokens[$j] === '{') {
   					$class = $tokens[$i+2][1] ?? null;
   				}
   			}
   		}
   		if ($class) break;
   	}
   	$className = ltrim( $namespace . '\\' . $class, '\\');
   	return $className;
   }
   

