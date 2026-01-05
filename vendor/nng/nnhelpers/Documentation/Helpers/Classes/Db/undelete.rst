
.. include:: ../../../../Includes.txt

.. _Db-undelete:

==============================================
Db::undelete()
==============================================

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
----------------------------------------------

Restore deleted database entry.
To do this, the flag for "``deleted``" is set to ``0`` again.

.. code-block:: php

	\nn\t3::Db()->undelete('table', $uid);
	\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@param string $table``
| ``@param array $constraint``
| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function undelete ( $table = '', $constraint = [] )
   {
   	if (!$constraint) return false;
   	if (is_numeric($constraint)) {
   		$constraint = ['uid' => $constraint];
   	}
   	if ($deleteColumn = $this->getDeleteColumn( $table )) {
   		return $this->update( $table, [$deleteColumn => 0], $constraint );
   	}
   	return false;
   }
   

