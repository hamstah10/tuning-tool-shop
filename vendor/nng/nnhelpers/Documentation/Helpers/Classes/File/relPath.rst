
.. include:: ../../../../Includes.txt

.. _File-relPath:

==============================================
File::relPath()
==============================================

\\nn\\t3::File()->relPath(``$path = ''``);
----------------------------------------------

relative path (from the current script) to a file / directory.
If no path is specified, the Typo3 root directory is returned.

.. code-block:: php

	\nn\t3::File()->relPath( $file ); => ../fileadmin/image.jpg
	\nn\t3::File()->relPath(); => ../

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
   

