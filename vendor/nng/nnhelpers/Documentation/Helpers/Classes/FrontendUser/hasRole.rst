
.. include:: ../../../../Includes.txt

.. _FrontendUser-hasRole:

==============================================
FrontendUser::hasRole()
==============================================

\\nn\\t3::FrontendUser()->hasRole(``$roleUid``);
----------------------------------------------

Checks whether the user has a specific role.

.. code-block:: php

	\nn\t3::FrontendUser()->hasRole( $roleUid );

| ``@param $role``
| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hasRole($roleUid)
   {
   	if (!$this->isLoggedIn()) return false;
   	$userGroupsByUid = $this->getCurrentUserGroups();
   	return $userGroupsByUid[$roleUid] ?? false;
   }
   

