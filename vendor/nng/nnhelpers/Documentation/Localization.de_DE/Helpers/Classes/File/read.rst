
.. include:: ../../../../Includes.txt

.. _File-read:

==============================================
File::read()
==============================================

\\nn\\t3::File()->read(``$src = NULL``);
----------------------------------------------

Holt den Inhalt einer Datei

.. code-block:: php

	\nn\t3::File()->read('fileadmin/text.txt');

| ``@return string|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function read($src = null)
   {
   	if (!$src || !$this->exists($src)) return '';
   	$absPath = $this->absPath($src);
   	if (!$absPath) return '';
   	return file_get_contents($absPath);
   }
   

