
.. include:: ../../../../Includes.txt

.. _Arrays-toArray:

==============================================
Arrays::toArray()
==============================================

\\nn\\t3::Arrays()->toArray();
----------------------------------------------

Gibt dieses Array-Object als "normales" Array zurück.

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->toArray();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray ()
   {
   	return (array) $this;
   }
   

