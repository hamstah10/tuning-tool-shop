
.. include:: ../../../../Includes.txt

.. _Obj-get:

==============================================
Obj::get()
==============================================

\\nn\\t3::Obj()->get(``$obj, $key = ''``);
----------------------------------------------

Access to a value in the object using the key
Alias to ``\nn\t3::Obj()->accessSingleProperty()``

.. code-block:: php

	\nn\t3::Obj()->get( $obj, 'title' );
	\nn\t3::Obj()->get( $obj, 'falMedia' );
	\nn\t3::Obj()->get( $obj, 'fal_media' );

| ``@param mixed $obj`` Model or array
| ``@param string $key`` the key / property

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $obj, $key = '' )
   {
   	return $this->accessSingleProperty($obj, $key);
   }
   

