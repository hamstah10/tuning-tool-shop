
.. include:: ../../../../Includes.txt

.. _Fal-unlink:

==============================================
Fal::unlink()
==============================================

\\nn\\t3::Fal()->unlink(``$uidOrObject = NULL``);
----------------------------------------------

Löscht ein SysFile und alle dazugehörigen SysFileReferences.
Alias zu ``\nn\t3::Fal()->deleteSysFile()``

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function unlink( $uidOrObject = null )
   {
   	return $this->deleteSysFile( $uidOrObject );
   }
   

