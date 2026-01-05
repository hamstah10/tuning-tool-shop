
.. include:: ../../../../Includes.txt

.. _Db-quote:

==============================================
Db::quote()
==============================================

\\nn\\t3::Db()->quote(``$value = ''``);
----------------------------------------------

A replacement for the ``mysqli_real_escape_string()`` method.

Should only be used in an emergency for low-level queries.
It is better to use ``preparedStatements``.

Only works with SQL, not with DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote('test'); // => 'test'
	$sword = \nn\t3::Db()->quote("test';SET"); // => 'test\';SET'
	$sword = \nn\t3::Db()->quote([1, 'test', '2']); // => [1, "'test'", '2']
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
   

