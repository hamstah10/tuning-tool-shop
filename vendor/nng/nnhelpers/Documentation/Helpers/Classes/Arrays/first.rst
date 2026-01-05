
.. include:: ../../../../Includes.txt

.. _Arrays-first:

==============================================
Arrays::first()
==============================================

\\nn\\t3::Arrays()->first();
----------------------------------------------

Returns the first element of the array, without array_shift()

.. code-block:: php

	\nn\t3::Arrays( $objArr )->first();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function first ()
   {
   	$arr = (array) $this;
   	if (!$arr) return false;
   	foreach ($arr as $k=>$v) return $v;
   }
   

