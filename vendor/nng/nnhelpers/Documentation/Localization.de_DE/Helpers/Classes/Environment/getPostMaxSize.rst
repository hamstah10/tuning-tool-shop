
.. include:: ../../../../Includes.txt

.. _Environment-getPostMaxSize:

==============================================
Environment::getPostMaxSize()
==============================================

\\nn\\t3::Environment()->getPostMaxSize();
----------------------------------------------

Maximale Upload-Größe für Dateien aus dem Frontend zurückgeben.
Diese Angabe ist der Wert, der in der php.ini festgelegt wurde und ggf.
über die .htaccess überschrieben wurde.

.. code-block:: php

	\nn\t3::Environment()->getPostMaxSize();  // z.B. '1048576' bei 1MB

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPostMaxSize() {
   	$postMaxSize = ini_get('post_max_size');
   	return \nn\t3::Convert($postMaxSize)->toBytes();
   }
   

