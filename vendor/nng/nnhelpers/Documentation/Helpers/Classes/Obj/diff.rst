
.. include:: ../../../../Includes.txt

.. _Obj-diff:

==============================================
Obj::diff()
==============================================

\\nn\\t3::Obj()->diff(``$objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = [], $path = '', $diff = []``);
----------------------------------------------

Compares two objects, returns array with differences.
If a property of objA does not exist in objB, it is ignored.

.. code-block:: php

	// Returns array with differences
	\nn\t3::Obj()->diff( $objA, $objB );
	
	// ignores the fields uid and title
	\nn\t3::Obj()->diff( $objA, $objB, ['uid', 'title'] );
	
	// Compares ONLY the fields title and bodytext
	\nn\t3::Obj()->diff( $objA, $objB, [], ['title', 'bodytext'] );
	
	// Options
	\nn\t3::Obj()->diff( $objA, $objB, [], [], ['ignoreWhitespaces'=>true, 'ignoreTags'=>true, 'ignoreEncoding'=>true] );

| ``@param mixed $objA`` An object, array or model
| ``@param mixed $objB`` The object or model to be compared
| ``@param array $fieldsToIgnore`` List of properties that can be ignored. Empty = none
| ``@param array $fieldsToCompare`` List of properties to be compared. Empty = all
| ``@param boolean $options`` Options / tolerances when comparing
| ``includeMissing`` => also add missing properties in $objB
| ``ignoreWhitespaces`` => ignore spaces
| ``ignoreEncoding`` => ignore UTF8 / ISO encoding
| ``ignoreTags`` => ignore HTML tags
| ``depth`` => depth to be compared

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function diff( $objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = [], $path = '', &$diff = [] )
   {
   	$arrA = $this->toArray( $objA, $options['depth'] ?? 3 );
   	$arrB = $this->toArray( $objB, $options['depth'] ?? 3 );
   	$includeMissing = $options['includeMissing'] ?? false;
   	// Keine Felder zum Vergleich angegeben? Dann alle nehmen
   	if (!$fieldsToCompare) {
   		$fieldsToCompare = array_keys( $arrA );
   	}
   	// Felder, die ignoriert werden sollen abziehen.
   	$fieldsToCheck = array_diff( $fieldsToCompare, $fieldsToIgnore );
   	foreach ($fieldsToCheck as $k=>$fieldName) {
   		$deep = $path . ($path === '' ? '' : '.') . "{$fieldName}";
   		$hasDiff = false;
   		$valA = $arrA[$fieldName];
   		$valB = $arrB[$fieldName] ?? null;
   		// Property existiert nur in objA? Dann ignorieren
   		if (!$includeMissing && !isset($arrB[$fieldName])) continue;
   		if (is_array($valA)) {
   			$this->diff($valA, $valB, [], [], $options, $deep, $diff);
   		} else {
   			// Einfacher String-Vergleich
   			$cmpA = $valA;
   			$cmpB = $valB;
   			if (is_string($cmpA) && is_string($cmpB)) {
   				if ($options['ignoreWhitespaces'] ?? false) {
   					$cmpA = preg_replace('/[\s\t]/', '', $cmpA);
   					$cmpB = preg_replace('/[\s\t]/', '', $cmpB);
   				}
   				if ($options['ignoreTags'] ?? false) {
   					$cmpA = strip_tags($cmpA);
   					$cmpB = strip_tags($cmpB);
   				}
   				if ($options['ignoreEncoding'] ?? false) {
   					$cmpA = \nn\t3::Convert($cmpA)->toUTF8();
   					$cmpB = \nn\t3::Convert($cmpB)->toUTF8();
   				}
   			}
   			$hasDiff = $cmpA != $cmpB;
   		}
   		// Gab es einen Unterschied? Dann diff-Array befüllen
   		if ($hasDiff) {
   			$diff[$deep] = [
   				'from'	=> $valA,
   				'to'	=> $valB,
   			];
   		}
   	}
   	return $diff;
   }
   

