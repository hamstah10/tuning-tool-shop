
.. include:: ../../../../Includes.txt

.. _File-exists:

==============================================
File::exists()
==============================================

\\nn\\t3::File()->exists(``$src = NULL``);
----------------------------------------------

Prüft, ob eine Datei existiert.
Gibt absoluten Pfad zur Datei zurück.

.. code-block:: php

	\nn\t3::File()->exists('fileadmin/bild.jpg');

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:file.exists(file:'pfad/zum/bild.jpg')}

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
   

