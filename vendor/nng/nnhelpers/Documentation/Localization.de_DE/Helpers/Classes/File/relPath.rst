
.. include:: ../../../../Includes.txt

.. _File-relPath:

==============================================
File::relPath()
==============================================

\\nn\\t3::File()->relPath(``$path = ''``);
----------------------------------------------

relativen Pfad (vom aktuellen Script aus) zum einer Datei / Verzeichnis zurück.
Wird kein Pfad angegeben, wird das Typo3-Root-Verzeichnis zurückgegeben.

.. code-block:: php

	\nn\t3::File()->relPath( $file );        => ../fileadmin/bild.jpg
	\nn\t3::File()->relPath();               => ../

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function relPath($path = '')
   {
   	if (!$path) $path = \nn\t3::Environment()->getPathSite();
   	$isFolder = $this->isFolder($path);
   	$path = $this->absPath($path);
   	$name = rtrim(PathUtility::getRelativePathTo($path), '/');
   	if ($isFolder) $name .= '/';
   	return $name;
   }
   

