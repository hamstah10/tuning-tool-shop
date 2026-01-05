
.. include:: ../../../../Includes.txt

.. _File-addPathSite:

==============================================
File::addPathSite()
==============================================

\\nn\\t3::File()->addPathSite(``$file``);
----------------------------------------------

Specifies path to file / folder WITH absolute path

Example:

.. code-block:: php

	\nn\t3::File()->addPathSite('fileadmin/test.jpg');
	 // ==> returns var/www/website/fileadmin/test.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addPathSite($file)
   {
   	return $this->stripPathSite($file, true);
   }
   

