
.. include:: ../../../../Includes.txt

.. _File-isFolder:

==============================================
File::isFolder()
==============================================

\\nn\\t3::File()->isFolder(``$file``);
----------------------------------------------

Returns whether the specified path is a folder

Example:

.. code-block:: php

	\nn\t3::File()->isFolder('fileadmin'); // => returns true

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFolder($file)
   {
   	if (substr($file, -1) == '/') return true;
   	return is_dir($this->absPath($file));
   }
   

