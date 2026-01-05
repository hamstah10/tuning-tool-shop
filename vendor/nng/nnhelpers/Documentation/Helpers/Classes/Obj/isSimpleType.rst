
.. include:: ../../../../Includes.txt

.. _Obj-isSimpleType:

==============================================
Obj::isSimpleType()
==============================================

\\nn\\t3::Obj()->isSimpleType(``$type = ''``);
----------------------------------------------

Checks whether a type (string) is a "simple" type.
Simple types are all types apart from models, classes etc. - e.g. ``array``, ``string``, ``boolean`` etc.

.. code-block:: php

	$isSimple = \nn\t3::Obj()->isSimpleType( 'string' ); // true
	$isSimple = \nn\t3::Obj()->isSimpleType( \My\Extname\ClassName::class ); // false

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isSimpleType( $type = '' )
   {
   	return in_array($type, ['array', 'string', 'float', 'double', 'integer', 'int', 'boolean', 'bool']);
   }
   

