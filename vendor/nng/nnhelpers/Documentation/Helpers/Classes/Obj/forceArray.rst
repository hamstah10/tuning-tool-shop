
.. include:: ../../../../Includes.txt

.. _Obj-forceArray:

==============================================
Obj::forceArray()
==============================================

\\nn\\t3::Obj()->forceArray(``$obj``);
----------------------------------------------

Converts to array

| ``@param mixed $obj``

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function forceArray($obj)
   {
   	if (!$obj) return [];
   	if ($this->isStorage($obj)) {
   		$tmp = [];
   		foreach ($obj as $k=>$v) {
   			$tmp[] = $v;
   		}
   		return $tmp;
   	}
   	return is_array($obj) ? $obj : [$obj];
   }
   

