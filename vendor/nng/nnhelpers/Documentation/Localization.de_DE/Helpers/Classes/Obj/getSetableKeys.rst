
.. include:: ../../../../Includes.txt

.. _Obj-getSetableKeys:

==============================================
Obj::getSetableKeys()
==============================================

\\nn\\t3::Obj()->getSetableKeys(``$obj``);
----------------------------------------------

Alle keys eines Objektes holen, die einen SETTER haben.
Im Gegensatz zu ``\nn\t3::Obj()->getKeys()`` werden nur die Property-Keys
zurückgegeben, die sich auch setzen lassen, z.B. über ``setNameDerProp()``

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSetableKeys( $obj )
   {
   	$props = $this->getProps( $obj, null, true );
   	return array_keys( $props );
   }
   

