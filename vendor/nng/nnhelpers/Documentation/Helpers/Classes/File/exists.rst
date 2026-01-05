
.. include:: ../../../../Includes.txt

.. _File-exists:

==============================================
File::exists()
==============================================

\\nn\\t3::File()->exists(``$src = NULL``);
----------------------------------------------

Checks whether a file exists.
Returns the absolute path to the file.

.. code-block:: php

	\nn\t3::File()->exists('fileadmin/image.jpg');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:file.exists(file:'path/to/image.jpg')}

| ``@return string|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function exists($src = null)
   {
   	if (file_exists($src)) return $src;
   	$src = $this->absPath($src);
   	if (file_exists($src)) return $src;
   	return false;
   }
   

