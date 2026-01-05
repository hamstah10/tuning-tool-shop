
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-parseFile:

==============================================
DocumentationHelper::parseFile()
==============================================

\\nn\\t3::DocumentationHelper()->parseFile(``$path = '', $returnMethods = true``);
----------------------------------------------

Get all information about a single PHP file.

Parses the annotation above the class definition and optionally also all methods of the class.
Returns an array where the arguments / parameters of each method are also listed.

Markdown can be used in the annotations, the Markdown is automatically converted to HTML code.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFile( 'Path/Classes/MyClass.php' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function parseFile( $path = '', $returnMethods = true )
   {
   	$className = self::getClassNameFromFile( $path );
   	$data = self::parseClass( $className, $returnMethods );
   	$data = array_merge($data, [
   		'path' 		=> $path,
   		'fileName'	=> pathinfo( $path, PATHINFO_FILENAME ),
   	]);
   	return $data;
   }
   

