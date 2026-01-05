
.. include:: ../../../../Includes.txt

.. _Obj-prop:

==============================================
Obj::prop()
==============================================

\\nn\\t3::Obj()->prop(``$obj, $key``);
----------------------------------------------

Access to a key in an object or array.
The key can also be a path, e.g. "img.0.uid"

\nn\t3::Obj()->prop( $obj, 'img.0.uid' );

| ``@param mixed $obj`` Model or array
| ``@param string $key`` the key that is to be fetched

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function prop ( $obj, $key )
   {
   	if ($key == '') return '';
   	$key = explode('.', $key);
   	if (count($key) == 1) return $this->accessSingleProperty($obj, $key[0]);
   	foreach ($key as $k) {
   		$obj = $this->accessSingleProperty($obj, $k);
   		if (!$obj) return '';
   	}
   	return $obj;
   }
   

