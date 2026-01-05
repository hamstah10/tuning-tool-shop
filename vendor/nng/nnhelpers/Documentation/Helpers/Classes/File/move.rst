
.. include:: ../../../../Includes.txt

.. _File-move:

==============================================
File::move()
==============================================

\\nn\\t3::File()->move(``$src = NULL, $dest = NULL``);
----------------------------------------------

Moves a file

.. code-block:: php

	\nn\t3::File()->move('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function move($src = null, $dest = null)
   {
   	if (!file_exists($src)) return false;
   	if (file_exists($dest)) return false;
   	rename($src, $dest);
   	return file_exists($dest);
   }
   

