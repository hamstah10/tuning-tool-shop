
.. include:: ../../../../Includes.txt

.. _Convert-toArray:

==============================================
Convert::toArray()
==============================================

\\nn\\t3::Convert()->toArray(``$obj = NULL, $depth = 3``);
----------------------------------------------

Converts a model into an array
Alias to \nn\t3::Obj()->toArray();

For memory problems due to recursion: Specify max depth!

.. code-block:: php

	\nn\t3::Convert($model)->toArray(2);
	\nn\t3::Convert($model)->toArray(); => ['uid'=>1, 'title'=>'Example', ...]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray( $obj = null, $depth = 3 ) {
   	if (is_int($obj)) $depth = $obj;
   	$obj = $this->initialArgument !== null ? $this->initialArgument : $obj;
   	return \nn\t3::Obj()->toArray($obj, $depth);
   }
   

