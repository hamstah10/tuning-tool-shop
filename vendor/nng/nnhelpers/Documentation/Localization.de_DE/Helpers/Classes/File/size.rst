
.. include:: ../../../../Includes.txt

.. _File-size:

==============================================
File::size()
==============================================

\\nn\\t3::File()->size(``$src = NULL``);
----------------------------------------------

Gibt Dateigröße zu einer Datei in Bytes zurück
Falls Datei nicht exisitert, wird 0 zurückgegeben.

.. code-block:: php

	\nn\t3::File()->size('fileadmin/bild.jpg');

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
   

