
.. include:: ../../../../Includes.txt

.. _File-addPathSite:

==============================================
File::addPathSite()
==============================================

\\nn\\t3::File()->addPathSite(``$file``);
----------------------------------------------

Gibt Pfad zu Datei / Ordner MIT absoluten Pfad

Beispiel:

.. code-block:: php

	\nn\t3::File()->addPathSite('fileadmin/test.jpg');
	 // ==> gibt var/www/website/fileadmin/test.jpg zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addPathSite($file)
   {
   	return $this->stripPathSite($file, true);
   }
   

