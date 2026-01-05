
.. include:: ../../../../Includes.txt

.. _Cache-write:

==============================================
Cache::write()
==============================================

\\nn\\t3::Cache()->write(``$identifier, $cache``);
----------------------------------------------

Statischen Datei-Cache schreiben.

Schreibt eine PHP-Datei, die per ``$cache = require('...')`` geladen werden kann.

Angelehnt an viele Core-Funktionen und Extensions (z.B. mask), die statische PHP-Dateien
ins Filesystem legen, um performancelastige Prozesse wie Klassenpfade, Annotation-Parsing etc.
besser zu cachen. Nutzt bewußt nicht die Core-Funktionen, um jeglichen Overhead zu
vermeiden und größtmögliche Kompatibilität bei Core-Updates zu gewährleisten.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

Das Beispiel oben generiert eine PHP-Datei mit diesem Inhalt:

.. code-block:: php

	<?php
	return ['_' => ['a'=>1, 'b'=>2]];

| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function write( $identifier, $cache )
   {
   	$this->set( $identifier, $cache, true );
   	$identifier = self::getIdentifier( $identifier );
   	$phpCode = '<?php return ' . var_export(['_' => $cache], true) . ';';
   	$path = \nn\t3::Environment()->getVarPath() . "cache/code/nnhelpers/{$identifier}.php";
   	\TYPO3\CMS\Core\Utility\GeneralUtility::writeFileToTypo3tempDir( $path, $phpCode );
   	return $cache;
   }
   

