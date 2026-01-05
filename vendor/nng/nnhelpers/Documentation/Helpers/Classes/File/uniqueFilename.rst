
.. include:: ../../../../Includes.txt

.. _File-uniqueFilename:

==============================================
File::uniqueFilename()
==============================================

\\nn\\t3::File()->uniqueFilename(``$filename = ''``);
----------------------------------------------

Creates a unique file name for the file if there is already
a file with an identical name already exists in the target directory
already exists in the target directory.

.. code-block:: php

	$name = \nn\t3::File()->uniqueFilename('fileadmin/01.jpg'); // 'fileadmin/01-1.jpg'

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function uniqueFilename($filename = '')
   {
   	$filename = $this->cleanFilename($filename);
   	if (!$this->exists($filename)) return $filename;
   	$path = pathinfo($filename, PATHINFO_DIRNAME) . '/';
   	$suffix = pathinfo($filename, PATHINFO_EXTENSION);
   	$filename = preg_replace('/-[0-9][0-9]$/', '', pathinfo($filename, PATHINFO_FILENAME));
   	$i = 0;
   	while ($i < 99) {
   		$i++;
   		$newName = $path . $filename . '-' . sprintf('%02d', $i) . '.' . $suffix;
   		if (!$this->exists($newName)) return $newName;
   	}
   	return $path . $filename . '-' . uniqid() . '.' . $suffix;
   }
   

