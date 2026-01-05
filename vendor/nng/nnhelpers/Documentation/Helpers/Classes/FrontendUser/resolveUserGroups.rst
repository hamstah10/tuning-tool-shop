
.. include:: ../../../../Includes.txt

.. _FrontendUser-resolveUserGroups:

==============================================
FrontendUser::resolveUserGroups()
==============================================

\\nn\\t3::FrontendUser()->resolveUserGroups(``$arr = [], $ignoreUids = []``);
----------------------------------------------

Converts an array or a comma-separated list with user group UIDs into
| ``fe_user_groups data`` from the database. Checks for inherited subgroup.

.. code-block:: php

	\nn\t3::FrontendUser()->resolveUserGroups( [1,2,3] );
	\nn\t3::FrontendUser()->resolveUserGroups( '1,2,3' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function resolveUserGroups( $arr = [], $ignoreUids = [] )
   {
   	$arr = \nn\t3::Arrays( $arr )->intExplode();
   	if (!$arr) return [];
   	return GeneralUtility::makeInstance(\TYPO3\CMS\Core\Authentication\GroupResolver::class)->resolveGroupsForUser(['usergroup'=>join(',', $arr)], 'fe_groups');
   }
   

