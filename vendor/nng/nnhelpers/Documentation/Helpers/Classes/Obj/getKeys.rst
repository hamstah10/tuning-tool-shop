
.. include:: ../../../../Includes.txt

.. _Obj-getKeys:

==============================================
Obj::getKeys()
==============================================

\\nn\\t3::Obj()->getKeys(``$obj``);
----------------------------------------------

Access to ALL keys that are to be fetched in an object

.. code-block:: php

	\nn\t3::Obj()->getKeys( $model ); // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( $model ); // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( \Nng\MyExt\Domain\Model\Demo::class ); // ['uid', 'title', 'text', ...]

| ``@param mixed $obj`` Model, array or class name
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getKeys ( $obj )
   {
   	if (is_string($obj) && class_exists($obj)) {
   		$obj = new $obj();
   	}
   	$keys = [];
   	if (is_object($obj)) {
   		return ObjectAccess::getGettablePropertyNames($obj);
   	} else if (is_array($obj)) {
   		return array_keys($obj);
   	}
   	return [];
   }
   

