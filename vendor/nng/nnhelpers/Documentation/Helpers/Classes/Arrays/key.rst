
.. include:: ../../../../Includes.txt

.. _Arrays-key:

==============================================
Arrays::key()
==============================================

\\nn\\t3::Arrays()->key(``$key = 'uid', $value = false``);
----------------------------------------------

Use a field in the array as the key of the array, e.g. to get a list,
whose key is always the UID of the associative array:

Example:

.. code-block:: php

	$arr = [['uid'=>'1', 'title'=>'Title A'], ['uid'=>'2', 'title'=>'Title B']];
	\nn\t3::Arrays($arr)->key('uid'); // ['1'=>['uid'=>'1', 'title'=>'Title A'], '2'=>['uid'=>'2', 'title'=>'Title B']]
	\nn\t3::Arrays($arr)->key('uid', 'title'); // ['1'=>'Title A', '2'=>'Title B']

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function key( $key = 'uid', $value = false ) {
   	$arr = (array) $this;
   	$values = $value === false ? array_values($arr) : array_column( $arr, $value );
   	$combinedArray = array_combine( array_column($arr, $key), $values );
   	$this->exchangeArray($combinedArray);
   	return $this;
   }
   

