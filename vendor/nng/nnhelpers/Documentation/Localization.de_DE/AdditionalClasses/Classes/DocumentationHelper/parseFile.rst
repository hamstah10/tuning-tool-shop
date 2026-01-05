
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-parseFile:

==============================================
DocumentationHelper::parseFile()
==============================================

\\nn\\t3::DocumentationHelper()->parseFile(``$path = '', $returnMethods = true``);
----------------------------------------------

Alle Infos zu einer einzelnen PHP-Datei holen.

Parsed den Kommentar (Annotation) über der Klassen-Definition und optional auch alle Methoden der Klasse.
Gibt ein Array zurück, bei der auch die Argumente / Parameter jeder Methode aufgeführt werden.

Markdown kann in den Annotations verwendet werden, das Markdown wird automatisch in HTML-Code umgewandelt.

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
   

