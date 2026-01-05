
.. include:: ../../../../Includes.txt

.. _Page-getChildPids:

==============================================
Page::getChildPids()
==============================================

\\nn\\t3::Page()->getChildPids(``$parentPid = 0, $recursive = 999``);
----------------------------------------------

Get list of child ids of one or more pages.

.. code-block:: php

	\nn\t3::Page()->getChildPids( 123, 1 );
	\nn\t3::Page()->getChildPids( [123, 124], 99 );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getChildPids( $parentPid = 0, $recursive = 999 )
   {
   	if (!$parentPid) return [];
   	if (!is_array($parentPid)) $parentPid = [$parentPid];
   	$mergedPids = [];
   	$treeRepository = GeneralUtility::makeInstance( PageRepository::class );
   	foreach ($parentPid as $pid) {
   		$childPids = \nn\t3::Arrays( $treeRepository->getPageIdsRecursive( [$pid], $recursive ) )->intExplode();
   		$mergedPids = array_merge( $childPids, $mergedPids );
   	}
   	return $mergedPids;
   }
   

