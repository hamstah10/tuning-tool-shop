
.. include:: ../../../../Includes.txt

.. _Arrays-removeEmpty:

==============================================
Arrays::removeEmpty()
==============================================

\\nn\\t3::Arrays()->removeEmpty();
----------------------------------------------

Leere Werte aus einem Array entfernen.

.. code-block:: php

	$clean = \nn\t3::Arrays( $arr1 )->removeEmpty();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function removeEmpty() {
   	return $this->merge( [], $this->toArray() );
   }
   

