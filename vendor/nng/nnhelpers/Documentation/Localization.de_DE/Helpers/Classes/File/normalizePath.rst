
.. include:: ../../../../Includes.txt

.. _File-normalizePath:

==============================================
File::normalizePath()
==============================================

\\nn\\t3::File()->normalizePath(``$path``);
----------------------------------------------

Löst ../../-Angaben in Pfad auf.
Funktioniert sowohl mit existierenden Pfaden (per realpath) als auch
nicht-existierenden Pfaden.

.. code-block:: php

	\nn\t3::File()->normalizePath( 'fileadmin/test/../bild.jpg' );     =>   fileadmin/bild.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function normalizePath($path)
   {
   	$hasTrailingSlash = substr($path, -1) == '/';
   	$hasStartingSlash = substr($path, 0, 1) == '/';
   	$path = array_reduce(explode('/', $path), function ($a, $b) {
   		if ($a === 0 || $a === null) $a = '/';
   		if ($b === '' || $b === '.') return $a;
   		if ($b === '..') return dirname($a);
   		return preg_replace('/\/+/', '/', "{$a}/{$b}");
   	}, 0);
   	if (!$hasStartingSlash) $path = ltrim($path, '/');
   	$isFolder = is_dir($path) || $hasTrailingSlash;
   	$path = rtrim($path, '/');
   	if ($isFolder) $path .= '/';
   	return $path;
   }
   

