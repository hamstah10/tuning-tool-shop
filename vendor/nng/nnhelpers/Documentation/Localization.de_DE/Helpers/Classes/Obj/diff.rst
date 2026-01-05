
.. include:: ../../../../Includes.txt

.. _Obj-diff:

==============================================
Obj::diff()
==============================================

\\nn\\t3::Obj()->diff(``$objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = [], $path = '', $diff = []``);
----------------------------------------------

Vergleicht zwei Objekte, gibt Array mit Unterschieden zurück.
Existiert eine Property von objA nicht in objB, wird diese ignoriert.

.. code-block:: php

	// gibt Array mit Unterschieden zurück
	\nn\t3::Obj()->diff( $objA, $objB );
	
	// ignoriert die Felder uid und title
	\nn\t3::Obj()->diff( $objA, $objB, ['uid', 'title'] );
	
	// Vergleicht NUR die Felder title und bodytext
	\nn\t3::Obj()->diff( $objA, $objB, [], ['title', 'bodytext'] );
	
	// Optionen
	\nn\t3::Obj()->diff( $objA, $objB, [], [], ['ignoreWhitespaces'=>true, 'ignoreTags'=>true, 'ignoreEncoding'=>true] );

| ``@param mixed $objA``                Ein Object, Array oder Model
| ``@param mixed $objB``                Das zu vergleichende Object oder Model
| ``@param array $fieldsToIgnore``       Liste der Properties, die ignoriert werden können. Leer = keine
| ``@param array $fieldsToCompare`` Liste der Properties, die verglichen werden sollen. Leer = alle
| ``@param boolean $options``       Optionen / Toleranzen beim Vergleichen
| ``includeMissing``    => auch fehlende Properties in $objB hinzufügen
| ``ignoreWhitespaces`` => Leerzeichen ignorieren
| ``ignoreEncoding``    => UTF8 / ISO-Encoding ignorieren
| ``ignoreTags``        => HTML-Tags ignorieren
| ``depth``             => Tiefe, die verglichen werden soll

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
   

