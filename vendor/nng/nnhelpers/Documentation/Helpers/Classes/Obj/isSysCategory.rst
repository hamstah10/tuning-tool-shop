
.. include:: ../../../../Includes.txt

.. _Obj-isSysCategory:

==============================================
Obj::isSysCategory()
==============================================

\\nn\\t3::Obj()->isSysCategory(``$obj``);
----------------------------------------------

Checks whether the object is a SysCategory.
Takes into account all models that are stored in ``sys_category``.

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
   

