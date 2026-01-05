
.. include:: ../../../../Includes.txt

.. _Obj-prop:

==============================================
Obj::prop()
==============================================

\\nn\\t3::Obj()->prop(``$obj, $key``);
----------------------------------------------

Zugriff auf einen Key in einem Object oder Array.
Der Key kann auch ein Pfad sein, z.B. "img.0.uid"

\nn\t3::Obj()->prop( $obj, 'img.0.uid' );

| ``@param mixed $obj`` Model oder Array
| ``@param string $key`` der Key, der geholt werden soll

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
   

