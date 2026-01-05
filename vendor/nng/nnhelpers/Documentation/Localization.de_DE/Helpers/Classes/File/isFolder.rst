
.. include:: ../../../../Includes.txt

.. _File-isFolder:

==============================================
File::isFolder()
==============================================

\\nn\\t3::File()->isFolder(``$file``);
----------------------------------------------

Gibt zurück, ob angegebener Pfad ein Ordner ist

Beispiel:

.. code-block:: php

	\nn\t3::File()->isFolder('fileadmin'); // => gibt true zurück

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFolder($file)
   {
   	if (substr($file, -1) == '/') return true;
   	return is_dir($this->absPath($file));
   }
   

