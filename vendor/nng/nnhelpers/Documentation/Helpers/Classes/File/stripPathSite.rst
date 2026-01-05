
.. include:: ../../../../Includes.txt

.. _File-stripPathSite:

==============================================
File::stripPathSite()
==============================================

\\nn\\t3::File()->stripPathSite(``$file, $prefix = false``);
----------------------------------------------

Specifies the path to the file / folder WITHOUT an absolute path.
Optionally, a prefix can be specified.

Example:

.. code-block:: php

	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg'); ==> fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', '../../'); ==> ../../fileadmin/test.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function stripPathSite($file, $prefix = false)
   {
   	$pathSite = \nn\t3::Environment()->getPathSite();
   	$file = str_replace($pathSite, '', $file);
   	if ($prefix === true) {
   		$file = $pathSite . $file;
   	} else if ($prefix !== false) {
   		$file = $prefix . $file;
   	}
   	return $file;
   }
   

