
.. include:: ../../../../Includes.txt

.. _Arrays-key:

==============================================
Arrays::key()
==============================================

\\nn\\t3::Arrays()->key(``$key = 'uid', $value = false``);
----------------------------------------------

Als Key des Arrays ein Feld im Array verwenden, z.B. um eine Liste zu bekommen,
deren Key immer die UID des assoziativen Arrays ist:

Beispiel:

.. code-block:: php

	$arr = [['uid'=>'1', 'title'=>'Titel A'], ['uid'=>'2', 'title'=>'Titel B']];
	\nn\t3::Arrays($arr)->key('uid');          // ['1'=>['uid'=>'1', 'title'=>'Titel A'], '2'=>['uid'=>'2', 'title'=>'Titel B']]
	\nn\t3::Arrays($arr)->key('uid', 'title');   // ['1'=>'Titel A', '2'=>'Titel B']

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
   

