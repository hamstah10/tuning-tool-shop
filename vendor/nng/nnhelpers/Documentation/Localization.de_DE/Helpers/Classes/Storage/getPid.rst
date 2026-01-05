
.. include:: ../../../../Includes.txt

.. _Storage-getPid:

==============================================
Storage::getPid()
==============================================

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
----------------------------------------------

Im Controller: Aktuelle StoragePid für ein PlugIn holen.
Alias zu ``\nn\t3::Settings()->getStoragePid()``

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
   

