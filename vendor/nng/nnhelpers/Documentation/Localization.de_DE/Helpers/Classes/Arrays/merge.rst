
.. include:: ../../../../Includes.txt

.. _Arrays-merge:

==============================================
Arrays::merge()
==============================================

\\nn\\t3::Arrays()->merge();
----------------------------------------------

Ein assoziatives Array rekursiv mit einem anderen Array mergen.

| ``$addKeys`` => wenn ``false`` werden nur Keys überschrieben, die auch in ``$arr1`` existieren
| ``$includeEmptyValues`` => wenn ``true`` werden auch leere Values in ``$arr1`` übernommen
| ``$enableUnsetFeature`` => wenn ``true``, kann ``__UNSET`` als Wert in ``$arr2`` verwendet werden, um eine Wert in ``$arr1`` zu löschen

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
   

