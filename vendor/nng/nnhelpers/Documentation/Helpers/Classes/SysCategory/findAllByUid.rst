
.. include:: ../../../../Includes.txt

.. _SysCategory-findAllByUid:

==============================================
SysCategory::findAllByUid()
==============================================

\\nn\\t3::SysCategory()->findAllByUid(``$branchUid = NULL``);
----------------------------------------------

Get list of all sys_categories, return ``uid`` as key

.. code-block:: php

	\nn\t3::SysCategory()->findAllByUid();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findAllByUid ( $branchUid = null )
   {
   	$allCategories = $this->findAll( $branchUid );
   	$allCategoriesByUid = [];
   	foreach ($allCategories as $cat) {
   		$allCategoriesByUid[$cat->getUid()] = $cat;
   	}
   	return $allCategoriesByUid;
   }
   

