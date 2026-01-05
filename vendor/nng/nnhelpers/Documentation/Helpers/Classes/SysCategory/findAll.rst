
.. include:: ../../../../Includes.txt

.. _SysCategory-findAll:

==============================================
SysCategory::findAll()
==============================================

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
----------------------------------------------

Get list of all sys_categories

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
   

