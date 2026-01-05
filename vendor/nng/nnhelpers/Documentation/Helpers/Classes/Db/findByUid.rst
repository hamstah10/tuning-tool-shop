
.. include:: ../../../../Includes.txt

.. _Db-findByUid:

==============================================
Db::findByUid()
==============================================

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
----------------------------------------------

Finds an entry based on the UID.
Also works if the frontend has not yet been initialized,
e.g. while AuthentificationService is running or in the scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param string $table``
| ``@param int $uid``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findByUid( $table = '', $uid = null, $ignoreEnableFields = false )
   {
   	$rows = $this->findByValues( $table, ['uid' => $uid], false, $ignoreEnableFields );
   	return $rows ? array_shift($rows) : [];
   }
   

