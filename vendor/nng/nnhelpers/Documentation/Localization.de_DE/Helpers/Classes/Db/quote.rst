
.. include:: ../../../../Includes.txt

.. _Db-quote:

==============================================
Db::quote()
==============================================

\\nn\\t3::Db()->quote(``$value = ''``);
----------------------------------------------

Ein Ersatz für die ``mysqli_real_escape_string()`` Methode.

Sollte nur im Notfall bei Low-Level Queries verwendet werden.
Besser ist es, ``preparedStatements`` zu verwenden.

Funktioniert nur bei SQL, nicht bei DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote('test');          // => 'test'
	$sword = \nn\t3::Db()->quote("test';SET");        // => 'test\';SET'
	$sword = \nn\t3::Db()->quote([1, 'test', '2']);  // => [1, "'test'", '2']
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@param string|array $value``
| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function quote( $value = '' )
   {
   	if (is_array($value)) {
   		foreach ($value as &$val) {
   			if (!is_numeric($val)) {
   				$val = $this->quote($val);
   			}
   		}
   		return $value;
   	}
   	return $this->getConnection()->quote( $value );
   }
   

