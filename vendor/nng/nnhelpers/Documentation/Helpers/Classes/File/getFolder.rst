
.. include:: ../../../../Includes.txt

.. _File-getFolder:

==============================================
File::getFolder()
==============================================

\\nn\\t3::File()->getFolder(``$file``);
----------------------------------------------

Returns the folder to a file

Example:

.. code-block:: php

	\nn\t3::File()->getFolder('fileadmin/test/example.txt');
	// ==> returns 'fileadmin/test/'

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
   

