
.. include:: ../../../../Includes.txt

.. _File-addSuffix:

==============================================
File::addSuffix()
==============================================

\\nn\\t3::File()->addSuffix(``$filename = NULL, $newSuffix = ''``);
----------------------------------------------

Replaces the suffix for a file name.

.. code-block:: php

	\nn\t3::File()->addSuffix('image', 'jpg'); // => image.jpg
	\nn\t3::File()->addSuffix('image.png', 'jpg'); // => image.jpg
	\nn\t3::File()->addSuffix('path/to/image.png', 'jpg'); // => path/to/image.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addSuffix($filename = null, $newSuffix = '')
   {
   	$suffix = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
   	if ($suffix) {
   		$filename = substr($filename, 0, -strlen($suffix) - 1);
   	}
   	return $filename . '.' . $newSuffix;
   }
   

