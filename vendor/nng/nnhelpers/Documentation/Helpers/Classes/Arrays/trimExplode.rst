
.. include:: ../../../../Includes.txt

.. _Arrays-trimExplode:

==============================================
Arrays::trimExplode()
==============================================

\\nn\\t3::Arrays()->trimExplode(``$delimiter = ',', $removeEmpty = true``);
----------------------------------------------

Split a string Ã¢ or array Ã¢ at the separator, remove empty elements
Works with strings and arrays.

.. code-block:: php

	\nn\t3::Arrays('1,,2,3')->trimExplode(); // [1,2,3]
	\nn\t3::Arrays('1,,2,3')->trimExplode( false ); // [1,'',2,3]
	\nn\t3::Arrays('1|2|3')->trimExplode('|'); // [1,2,3]
	\nn\t3::Arrays('1|2||3')->trimExplode('|', false); // [1,2,'',3]
	\nn\t3::Arrays('1|2,3')->trimExplode(['|', ',']); // [1,2,3]
	\nn\t3::Arrays(['1','','2','3'])->trimExplode(); // [1,2,3]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function trimExplode( $delimiter = ',', $removeEmpty = true ) {
   	$arr = $this->initialArgument !== null ? $this->initialArgument : (array) $this;
   	if ($delimiter === false || $delimiter === true) {
   		$delimiter = ',';
   		$removeEmpty = $delimiter;
   	}
   	$firstDelimiter = is_array($delimiter) ? $delimiter[0] : $delimiter;
   	if (is_array($arr)) $arr = join($firstDelimiter, $arr);
   	if (is_array($delimiter)) {
   		foreach ($delimiter as $d) {
   			$arr = str_replace( $d, $firstDelimiter, $arr);
   		}
   		$delimiter = $firstDelimiter;
   	}
   	$arr = GeneralUtility::trimExplode( $delimiter, $arr, $removeEmpty );
   	return $arr;
   }
   

