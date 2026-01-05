
.. include:: ../../../../Includes.txt

.. _File-stripBaseUrl:

==============================================
File::stripBaseUrl()
==============================================

\\nn\\t3::File()->stripBaseUrl(``$file``);
----------------------------------------------

Removes the URL if it corresponds to the current domain

Example:

.. code-block:: php

	\nn\t3::File()->stripBaseUrl('https://www.my-web.de/fileadmin/test.jpg'); ==> fileadmin/test.jpg
	\nn\t3::File()->stripBaseUrl('https://www.other-web.de/example.jpg'); ==> https://www.other-web.de/example.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function stripBaseUrl($file)
   {
   	$baseUrl = \nn\t3::Environment()->getBaseURL();
   	$file = str_replace($baseUrl, '', $file);
   	return $file;
   }
   

