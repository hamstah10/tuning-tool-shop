
.. include:: ../../../../Includes.txt

.. _File-getFolder:

==============================================
File::getFolder()
==============================================

\\nn\\t3::File()->getFolder(``$file``);
----------------------------------------------

Gibt den Ordner zu einer Datei zurück

Beispiel:

.. code-block:: php

	\nn\t3::File()->getFolder('fileadmin/test/beispiel.txt');
	// ==> gibt 'fileadmin/test/' zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFolder($file)
   {
   	$pathSite = \nn\t3::Environment()->getPathSite();
   	$file = str_replace($pathSite, '', $file);
   	if (substr($file, -1) == '/') return $file;
   	if (is_dir($pathSite . $file)) return $file;
   	if (!pathinfo($file, PATHINFO_EXTENSION)) return $file . '/';
   	return dirname($file) . '/';
   }
   

