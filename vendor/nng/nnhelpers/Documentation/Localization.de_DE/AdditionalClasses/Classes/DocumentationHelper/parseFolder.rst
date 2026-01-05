
.. include:: ../../../../Includes.txt

.. _DocumentationHelper-parseFolder:

==============================================
DocumentationHelper::parseFolder()
==============================================

\\nn\\t3::DocumentationHelper()->parseFolder(``$path = '', $options = []``);
----------------------------------------------

Einen Ordner (rekursiv) nach Klassen mit Annotations parsen.
Gibt ein Array mit Informationen zu jeder Klasse und seinen Methoden zurück.

Die Annotations (Kommentare) über den Klassen-Methoden können in Markdown formatiert werden, sie werden automatisch in HTML mit passenden ``<pre>`` und ``<code>`` Tags umgewandelt.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/To/Classes/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'EXT:myext/Classes/ViewHelpers/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/Somewhere/', ['recursive'=>false, 'suffix'=>'php', 'parseMethods'=>false] );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function parseFolder( $path = '', $options = [] )
   {
   	$options = array_merge([
   		'recursive' 	=> true,
   		'suffix'		=> 'php',
   		'parseMethods'	=> true,
   	], $options);
   	$classList = [];
   	$fileList = [];
   	$suffix = $options['suffix'];
   	$path = \nn\t3::File()->absPath($path);
   	if ($options['recursive']) {
   		$iterator = new \RecursiveIteratorIterator(
   			new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)
   		);
   		foreach ($iterator as $file) {
   			if ($file->isFile() && $file->getExtension() === $suffix) {
   				$fileList[] = $file->getPathname();
   			}
   		}
   	} else {
   		$iterator = new \DirectoryIterator($path);
   		foreach ($iterator as $file) {
   			if ($file->isFile() && $file->getExtension() === $suffix) {
   				$fileList[] = $file->getPathname();
   			}
   		}
   	}
   	// Durch alle php-Dateien im Verzeichnis Classes/Utilities/ gehen
   	foreach ($fileList as $path) {
   		$classInfo = self::parseFile( $path, $options['parseMethods'] );
   		$className = $classInfo['className'];
   		$classList[$className] = $classInfo;
   	}
   	ksort($classList);
   	return $classList;
   }
   

