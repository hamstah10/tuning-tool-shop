
.. include:: ../../../../Includes.txt

.. _Obj-isSysCategory:

==============================================
Obj::isSysCategory()
==============================================

\\nn\\t3::Obj()->isSysCategory(``$obj``);
----------------------------------------------

Prüft, ob es sich bei dem Object um eine SysCategory handelt.
Berücksichtigt alle Modelle, die in ``sys_category`` gespeichert werden.

.. code-block:: php

	\nn\t3::Obj()->isSysCategory( $obj );
	
	$cat = new \GeorgRinger\News\Domain\Model\Category();
	\nn\t3::Obj()->isSysCategory( $cat );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isSysCategory ( $obj )
   {
   	if (!is_object($obj)) return false;
   	if (is_a($obj, \TYPO3\CMS\Extbase\Domain\Model\Category::class)) return true;
   	$tableName = \nn\t3::Obj()->getTableName($obj);
   	return $tableName == 'sys_category';
   }
   

