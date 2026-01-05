
.. include:: ../../../../Includes.txt

.. _Convert-toJson:

==============================================
Convert::toJson()
==============================================

\\nn\\t3::Convert()->toJson(``$obj = NULL, $depth = 3``);
----------------------------------------------

Konvertiert ein Model in ein JSON

.. code-block:: php

	\nn\t3::Convert($model)->toJson()        => ['uid'=>1, 'title'=>'Beispiel', ...]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toJson( $obj = null, $depth = 3 ) {
   	return json_encode( $this->toArray($obj, $depth) );
   }
   

