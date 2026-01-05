
.. include:: ../../../../Includes.txt

.. _File-suffix:

==============================================
File::suffix()
==============================================

\\nn\\t3::File()->suffix(``$filename = NULL``);
----------------------------------------------

Gibt den Suffix der Datei zurück

.. code-block:: php

	\nn\t3::File()->suffix('bild.jpg');    => gibt 'jpg' zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function suffix($filename = null)
   {
   	if (!$filename) return false;
   	$suffix = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
   	$suffix = preg_replace('/\?.*/', '', $suffix);
   	if ($suffix == 'jpeg') $suffix = 'jpg';
   	return $suffix;
   }
   

