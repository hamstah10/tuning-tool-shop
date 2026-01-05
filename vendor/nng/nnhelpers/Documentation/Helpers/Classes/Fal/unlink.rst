
.. include:: ../../../../Includes.txt

.. _Fal-unlink:

==============================================
Fal::unlink()
==============================================

\\nn\\t3::Fal()->unlink(``$uidOrObject = NULL``);
----------------------------------------------

Deletes a SysFile and all associated SysFileReferences.
Alias to ``\nn\t3::Fal()->deleteSysFile()``

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function unlink( $uidOrObject = null )
   {
   	return $this->deleteSysFile( $uidOrObject );
   }
   

