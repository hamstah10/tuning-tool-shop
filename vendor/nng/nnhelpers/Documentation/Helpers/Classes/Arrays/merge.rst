
.. include:: ../../../../Includes.txt

.. _Arrays-merge:

==============================================
Arrays::merge()
==============================================

\\nn\\t3::Arrays()->merge();
----------------------------------------------

Merge an associative array recursively with another array.

| ``$addKeys`` => if ``false``, only keys that also exist in ``$arr1`` are overwritten
| ``$includeEmptyValues`` => if ``true``, empty values are also included in ``$arr1`` 
| ``$enableUnsetFeature`` => if ``true``, ``__UNSET`` can be used as a value in ``$arr2`` to delete a value in ``$arr1`` 

.. code-block:: php

	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2, $addKeys, $includeEmptyValues, $enableUnsetFeature );
	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2 );
	$mergedArray = \nn\t3::Arrays()->merge( $arr1, $arr2 );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function merge() {
   	$defaultArgs = [
   		'arr1' 		=> [],
   		'arr2' 		=> [],
   		'addKeys' 	=> true,
   		'includeEmptyValues' => false,
   		'enableUnsetFeature' => true,
   	];
   	$args = func_get_args();
   	if ($this->initialArgument !== null && !is_array($args[1] ?? '')) {
   		array_unshift($args, $this->initialArgument );
   	}
   	foreach ($defaultArgs as $k=>$v) {
   		$val = array_shift( $args );
   		if ($val == null) $val = $v;
   		${$k} = $val;
   	}
   	ArrayUtility::mergeRecursiveWithOverrule($arr1, $arr2, $addKeys, $includeEmptyValues, $enableUnsetFeature );
   	return $arr1;
   }
   

