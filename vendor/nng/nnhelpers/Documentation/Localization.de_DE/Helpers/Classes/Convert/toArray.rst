
.. include:: ../../../../Includes.txt

.. _Convert-toArray:

==============================================
Convert::toArray()
==============================================

\\nn\\t3::Convert()->toArray(``$obj = NULL, $depth = 3``);
----------------------------------------------

Konvertiert ein Model in ein Array
Alias zu \nn\t3::Obj()->toArray();

Bei Memory-Problemen wegen Rekursionen: Max-Tiefe angebenen!

.. code-block:: php

	\nn\t3::Convert($model)->toArray(2);
	\nn\t3::Convert($model)->toArray();      => ['uid'=>1, 'title'=>'Beispiel', ...]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray( $obj = null, $depth = 3 ) {
   	if (is_int($obj)) $depth = $obj;
   	$obj = $this->initialArgument !== null ? $this->initialArgument : $obj;
   	return \nn\t3::Obj()->toArray($obj, $depth);
   }
   

