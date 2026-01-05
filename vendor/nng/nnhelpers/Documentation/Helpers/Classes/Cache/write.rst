
.. include:: ../../../../Includes.txt

.. _Cache-write:

==============================================
Cache::write()
==============================================

\\nn\\t3::Cache()->write(``$identifier, $cache``);
----------------------------------------------

Write static file cache.

Writes a PHP file that can be loaded via ``$cache = require('...')``.

Based on many core functions and extensions (e.g. mask), which place static PHP files
into the file system in order to better cache performance-intensive processes such as class paths, annotation parsing etc.
better. Deliberately do not use the core functions in order to avoid any overhead and
and to ensure the greatest possible compatibility with core updates.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

The example above generates a PHP file with this content:

.. code-block:: php

	 ['a'=>1, 'b'=>2]];

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
   

