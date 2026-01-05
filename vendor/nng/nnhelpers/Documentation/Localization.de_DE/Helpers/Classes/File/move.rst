
.. include:: ../../../../Includes.txt

.. _File-move:

==============================================
File::move()
==============================================

\\nn\\t3::File()->move(``$src = NULL, $dest = NULL``);
----------------------------------------------

Verschiebt eine Datei

.. code-block:: php

	\nn\t3::File()->move('fileadmin/bild.jpg', 'fileadmin/bild-kopie.jpg');

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
   

