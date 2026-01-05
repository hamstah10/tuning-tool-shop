
.. include:: ../../../../Includes.txt

.. _Obj-isSimpleType:

==============================================
Obj::isSimpleType()
==============================================

\\nn\\t3::Obj()->isSimpleType(``$type = ''``);
----------------------------------------------

Prüft, ob es sich bei einem Typ (string) um einen "einfachen" Typ handelt.
Einfache Typen sind alle Typen außer Models, Klassen etc. - also z.B. ``array``, ``string``, ``boolean`` etc.

.. code-block:: php

	$isSimple = \nn\t3::Obj()->isSimpleType( 'string' );                           // true
	$isSimple = \nn\t3::Obj()->isSimpleType( \My\Extname\ClassName::class );     // false

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isSimpleType( $type = '' )
   {
   	return in_array($type, ['array', 'string', 'float', 'double', 'integer', 'int', 'boolean', 'bool']);
   }
   

