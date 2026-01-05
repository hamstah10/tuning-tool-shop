
.. include:: ../../../../Includes.txt

.. _Obj-getSetableKeys:

==============================================
Obj::getSetableKeys()
==============================================

\\nn\\t3::Obj()->getSetableKeys(``$obj``);
----------------------------------------------

Get all keys of an object that have a SETTER.
In contrast to ``\nn\t3::Obj()->getKeys()``, only the property keys are
are returned that can also be set, e.g. via ``setNameDerProp()``

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSetableKeys( $obj )
   {
   	$props = $this->getProps( $obj, null, true );
   	return array_keys( $props );
   }
   

