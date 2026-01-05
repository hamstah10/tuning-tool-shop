
.. include:: ../../../../Includes.txt

.. _Environment-getPostMaxSize:

==============================================
Environment::getPostMaxSize()
==============================================

\\nn\\t3::Environment()->getPostMaxSize();
----------------------------------------------

Return maximum upload size for files from the frontend.
This specification is the value that was defined in php.ini and, if necessary
was overwritten via the .htaccess.

.. code-block:: php

	\nn\t3::Environment()->getPostMaxSize(); // e.g. '1048576' for 1MB

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPostMaxSize() {
   	$postMaxSize = ini_get('post_max_size');
   	return \nn\t3::Convert($postMaxSize)->toBytes();
   }
   

