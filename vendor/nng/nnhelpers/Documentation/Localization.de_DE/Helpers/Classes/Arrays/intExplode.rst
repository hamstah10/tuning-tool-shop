
.. include:: ../../../../Includes.txt

.. _Arrays-intExplode:

==============================================
Arrays::intExplode()
==============================================

\\nn\\t3::Arrays()->intExplode(``$delimiter = ','``);
----------------------------------------------

Einen String – oder Array – am Trennzeichen splitten, nicht numerische
und leere Elemente entfernen

.. code-block:: php

	\nn\t3::Arrays('1,a,b,2,3')->intExplode();     // [1,2,3]
	\nn\t3::Arrays(['1','a','2','3'])->intExplode(); // [1,2,3]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function intExplode( $delimiter = ',' ) {
   	$finals = [];
   	if ($arr = $this->trimExplode($delimiter)) {
   		foreach ($arr as $k=>$v) {
   			if (is_numeric($v)) $finals[] = $v;
   		}
   	}
   	return $finals;
   }
   

