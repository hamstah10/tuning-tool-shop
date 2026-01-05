
.. include:: ../../../../Includes.txt

.. _SysCategory-findAll:

==============================================
SysCategory::findAll()
==============================================

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
----------------------------------------------

Liste aller sys_categories holen

.. code-block:: php

	\nn\t3::SysCategory()->findAll();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findAll ( $branchUid = null )
   {
   	$categoryRepository = \nn\t3::injectClass( CategoryRepository::class );
   	$allCategories = $categoryRepository->findAll();
   	return $allCategories;
   }
   

