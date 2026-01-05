
.. include:: ../../../../Includes.txt

.. _Arrays-toArray:

==============================================
Arrays::toArray()
==============================================

\\nn\\t3::Arrays()->toArray();
----------------------------------------------

Returns this array object as a "normal" array.

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
   

