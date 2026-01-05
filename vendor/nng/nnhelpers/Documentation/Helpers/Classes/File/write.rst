
.. include:: ../../../../Includes.txt

.. _File-write:

==============================================
File::write()
==============================================

\\nn\\t3::File()->write(``$path = NULL, $content = NULL``);
----------------------------------------------

Create a folder and/or file.
Also creates the folders if they do not exist.

.. code-block:: php

	\nn\t3::File()->write('fileadmin/some/deep/folder/');
	\nn\t3::File()->write('1:/some/deep/folder/');
	\nn\t3::File()->write('fileadmin/some/deep/folder/file.json', 'TEXT');

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function write($path = null, $content = null)
   {
   	$path = \nn\t3::File()->absPath($path);
   	$folder = pathinfo($path, PATHINFO_DIRNAME);
   	$exists = \nn\t3::File()->mkdir($folder);
   	if ($exists && $content !== null) {
   		return file_put_contents($path, $content) !== false;
   	}
   	return $exists;
   }
   

