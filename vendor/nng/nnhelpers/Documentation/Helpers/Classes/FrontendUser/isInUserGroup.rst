
.. include:: ../../../../Includes.txt

.. _FrontendUser-isInUserGroup:

==============================================
FrontendUser::isInUserGroup()
==============================================

\\nn\\t3::FrontendUser()->isInUserGroup(``$feGroups = NULL``);
----------------------------------------------

Checks whether the current frontend user is within a specific user group.

.. code-block:: php

	\nn\t3::FrontendUser()->isInUserGroup( 1 );
	\nn\t3::FrontendUser()->isInUserGroup( ObjectStorage );
	\nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	\nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isInUserGroup( $feGroups = null )
   {
   	if (!$this->isLoggedIn()) return false;
   	$groupsByUid = $this->getCurrentUserGroups();
   	$feGroupUids = [];
   	if (is_int( $feGroups)) {
   		$feGroupUids = [$feGroups];
   	} else {
   		foreach ($feGroups as $obj) {
   			$uid = false;
   			if (is_numeric($obj)) $uid = $obj;
   			if (is_array($obj) && isset($obj['uid'])) $uid = $obj['uid'];
   			if (is_object($obj) && method_exists($obj, 'getUid')) $uid = $obj->getUid();
   			if ($uid) $feGroupUids[] = $uid;
   		}
   	}
   	$matches = array_intersect( array_keys($groupsByUid), $feGroupUids );
   	return count($matches) > 0;
   }
   

