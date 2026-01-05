
.. include:: ../../../../Includes.txt

.. _Db-findByUids:

==============================================
Db::findByUids()
==============================================

\\nn\\t3::Db()->findByUids(``$table = '', $uids = NULL, $ignoreEnableFields = false``);
----------------------------------------------

Findet Einträge anhand mehrerer UIDs.

.. code-block:: php

	\nn\t3::Db()->findByUids('fe_user', [12,13]);
	\nn\t3::Db()->findByUids('fe_user', [12,13], true);

| ``@param string $table``
| ``@param int|array $uids``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findByUids( $table = '', $uids = null, $ignoreEnableFields = false )
   {
   	if (!$uids) return [];
   	$rows = $this->findByValues( $table, ['uid' => $uids], false, $ignoreEnableFields );
   	return $rows;
   }
   

