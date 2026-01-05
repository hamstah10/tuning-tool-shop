
.. include:: ../../../../Includes.txt

.. _File-addSuffix:

==============================================
File::addSuffix()
==============================================

\\nn\\t3::File()->addSuffix(``$filename = NULL, $newSuffix = ''``);
----------------------------------------------

Ersetzt den suffix für einen Dateinamen.

.. code-block:: php

	\nn\t3::File()->addSuffix('bild', 'jpg');                //  => bild.jpg
	\nn\t3::File()->addSuffix('bild.png', 'jpg');            //  => bild.jpg
	\nn\t3::File()->addSuffix('pfad/zu/bild.png', 'jpg');    //  => pfad/zu/bild.jpg

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
   

