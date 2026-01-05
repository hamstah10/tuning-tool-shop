
.. include:: ../../../../Includes.txt

.. _Obj-get:

==============================================
Obj::get()
==============================================

\\nn\\t3::Obj()->get(``$obj, $key = ''``);
----------------------------------------------

Zugriff auf einen Wert in dem Object anhand des Keys
Alias zu ``\nn\t3::Obj()->accessSingleProperty()``

.. code-block:: php

	\nn\t3::Obj()->get( $obj, 'title' );
	\nn\t3::Obj()->get( $obj, 'falMedia' );
	\nn\t3::Obj()->get( $obj, 'fal_media' );

| ``@param mixed $obj``             Model oder Array
| ``@param string $key``            der Key / Property

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $obj, $key = '' )
   {
   	return $this->accessSingleProperty($obj, $key);
   }
   

