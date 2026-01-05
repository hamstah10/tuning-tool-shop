
.. include:: ../../../../Includes.txt

.. _Storage-getPid:

==============================================
Storage::getPid()
==============================================

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
----------------------------------------------

In the controller: Get current StoragePid for a plug-in.
Alias to ``\nn\t3::Settings()->getStoragePid()``

.. code-block:: php

	\nn\t3::Storage()->getPid();
	\nn\t3::Storage()->getPid('news');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPid ( $extName = null )
   {
   	return \nn\t3::Settings()->getStoragePid( $extName );
   }
   

