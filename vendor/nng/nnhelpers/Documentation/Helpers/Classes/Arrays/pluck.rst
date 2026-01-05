
.. include:: ../../../../Includes.txt

.. _Arrays-pluck:

==============================================
Arrays::pluck()
==============================================

\\nn\\t3::Arrays()->pluck(``$keys = NULL, $isSingleObject = false``);
----------------------------------------------

Reduce / distill associative array to specific elements:

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->pluck('title'); // ['1'=>'title A', '2'=>'title B']
	\nn\t3::Arrays( $objArr )->key('uid')->pluck(['title', 'bodytext']); // ['1'=>['title'=>'Title A', 'bodytext'=>'Content'], '2'=>...]
	\nn\t3::Arrays( ['uid'=>1, 'pid'=>2] )->pluck(['uid'], true); // ['uid'=>1]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function pluck( $keys = null, $isSingleObject = false ) {
   	$arr = (array) $this;
   	$pluckedArray = [];
   	if ($getSingleKey = is_string($keys)) {
   		$keys = [$keys];
   	}
   	if ($isSingleObject) {
   		$arr = [$arr];
   	}
   	foreach ($keys as $key) {
   		foreach ($arr as $n=>$v) {
   			if ($getSingleKey) {
   				$pluckedArray[$n] = $v[$key] ?? '';
   			} else {
   				if (!isset($pluckedArray[$n])) $pluckedArray[$n] = [];
   				$pluckedArray[$n][$key] = $v[$key] ?? '';
   			}
   		}
   	}
   	if ($isSingleObject) {
   		$pluckedArray = array_pop($pluckedArray);
   	}
   	$this->exchangeArray($pluckedArray);
   	return $this;
   }
   

