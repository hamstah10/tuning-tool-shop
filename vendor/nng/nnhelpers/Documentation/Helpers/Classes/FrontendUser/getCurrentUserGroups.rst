
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCurrentUserGroups:

==============================================
FrontendUser::getCurrentUserGroups()
==============================================

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
----------------------------------------------

Get user groups of the current FE user as an array.
The uids of the user groups are used as keys in the returned array.

.. code-block:: php

	// Minimal version: By default, Typo3 only returns title, uid and pid
	\nn\t3::FrontendUser()->getCurrentUserGroups(); // [1 => ['title'=>'Group A', 'uid' => 1, 'pid'=>5]]
	
	// If true, the complete data record for the fe_user_group can be read from the DB
	\nn\t3::FrontendUser()->getCurrentUserGroups( true ); // [1 => [... all fields of the DB] ]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCurrentUserGroups( $returnRowData = false )
   {
   	if (!$this->isLoggedIn()) return [];
   	if (($user = $this->getFrontendUser() ?? null)) {
   		// Wenn wir ein Frontend haben...
   		$rawGroupData = $user->groupData ?? [];
   		$groupDataByUid = [];
   		foreach (($rawGroupData['uid'] ?? []) as $i=>$uid) {
   			$groupDataByUid[$uid] = [];
   			if ($returnRowData) {
   				$groupDataByUid[$uid] = \nn\t3::Db()->findByUid('fe_groups', $uid);
   			}
   			foreach ($rawGroupData as $field=>$arr) {
   				$groupDataByUid[$uid][$field] = $arr[$i];
   			}
   		}
   		return $groupDataByUid;
   	}
   	// ... oder in einem Kontext ohne Frontend sind (z.B. einer Middleware)
   	$context = GeneralUtility::makeInstance(Context::class);
   	$userAspect = $context->getAspect('frontend.user');
   	if (!$userAspect) return [];
   	$userGroups = $this->resolveUserGroups($userAspect->get('groupIds'));
   	if ($returnRowData) {
   		return \nn\t3::Arrays($userGroups)->key('uid')->toArray() ?: [];
   	} else {
   		return \nn\t3::Arrays($userGroups)->key('uid')->pluck(['uid', 'title', 'pid'])->toArray();
   	}
   	return [];
   }
   

