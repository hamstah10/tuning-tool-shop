
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCurrentUserGroups:

==============================================
FrontendUser::getCurrentUserGroups()
==============================================

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
----------------------------------------------

Benutzergruppen des aktuellen FE-Users als Array holen.
Die uids der Benutzergruppen werden im zurückgegebenen Array als Key verwendet.

.. code-block:: php

	// Minimalversion: Per default gibt Typo3 nur title, uid und pid zurück
	\nn\t3::FrontendUser()->getCurrentUserGroups();          // [1 => ['title'=>'Gruppe A', 'uid' => 1, 'pid'=>5]]
	
	// Mit true kann der komplette Datensatz für die fe_user_group aus der DB gelesen werden
	\nn\t3::FrontendUser()->getCurrentUserGroups( true );    // [1 => [... alle Felder der DB] ]

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
   

