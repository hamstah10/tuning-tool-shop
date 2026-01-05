
.. include:: ../../../../Includes.txt

.. _File-size:

==============================================
File::size()
==============================================

\\nn\\t3::File()->size(``$src = NULL``);
----------------------------------------------

Returns the file size of a file in bytes
If file does not exist, 0 is returned.

.. code-block:: php

	\nn\t3::File()->size('fileadmin/image.jpg');

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function size($src = null)
   {
   	$src = $this->exists($src);
   	if (!$src) return 0;
   	return filesize($src);
   }
   

