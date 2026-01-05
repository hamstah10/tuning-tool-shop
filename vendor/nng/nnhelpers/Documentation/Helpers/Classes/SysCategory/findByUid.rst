
.. include:: ../../../../Includes.txt

.. _SysCategory-findByUid:

==============================================
SysCategory::findByUid()
==============================================

\\nn\\t3::SysCategory()->findByUid(``$uidList = NULL``);
----------------------------------------------

Get sys_categories by uid(s).

.. code-block:: php

	\nn\t3::SysCategory()->findByUid( 12 );
	\nn\t3::SysCategory()->findByUid( '12,11,5' );
	\nn\t3::SysCategory()->findByUid( [12, 11, 5] );

| ``@return array|\TYPO3\CMS\Extbase\Domain\Model\Category``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findByUid( $uidList = null )
   {
   	$returnFirst = !is_array($uidList) && is_numeric($uidList);
   	$uidList = \nn\t3::Arrays($uidList)->intExplode();
   	$allCategoriesByUid = $this->findAllByUid();
   	$result = [];
   	foreach ($uidList as $uid) {
   		if ($cat = $allCategoriesByUid[$uid]) {
   			$result[$uid] = $cat;
   		}
   	}
   	return $returnFirst ? array_shift($result) : $result;
   }
   

