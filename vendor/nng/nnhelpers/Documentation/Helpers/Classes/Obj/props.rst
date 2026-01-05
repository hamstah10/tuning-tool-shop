
.. include:: ../../../../Includes.txt

.. _Obj-props:

==============================================
Obj::props()
==============================================

\\nn\\t3::Obj()->props(``$obj, $keys = []``);
----------------------------------------------

Get individual properties of an object or array

.. code-block:: php

	\nn\t3::Obj()->props( $obj, ['uid', 'pid'] );
	\nn\t3::Obj()->props( $obj, 'uid' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function props ( $obj, $keys = [] )
   {
   	if (is_string($keys)) {
   		$keys = [$keys];
   	}
   	$arr = [];
   	foreach ($keys as $k) {
   		$arr[$k] = $this->prop( $obj, $k );
   	}
   	return $arr;
   }
   

