
.. include:: ../../../../Includes.txt

.. _Db-getDeleteColumn:

==============================================
Db::getDeleteColumn()
==============================================

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
----------------------------------------------

Delete-Column für bestimmte Tabelle holen.

Diese Spalte wird als Flag für gelöschte Datensätze verwendet.
Normalerweise: ``deleted`` = 1

| ``@param string $table``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getDeleteColumn ( $table = '' )
   {
   	$ctrl = $GLOBALS['TCA'][$table]['ctrl'] ?? [];
   	return $ctrl['delete'] ?? false;
   }
   

