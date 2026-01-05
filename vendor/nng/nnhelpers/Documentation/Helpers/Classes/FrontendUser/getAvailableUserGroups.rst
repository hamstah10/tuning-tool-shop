
.. include:: ../../../../Includes.txt

.. _FrontendUser-getAvailableUserGroups:

==============================================
FrontendUser::getAvailableUserGroups()
==============================================

\\nn\\t3::FrontendUser()->getAvailableUserGroups(``$returnRowData = false``);
----------------------------------------------

Return all existing user groups.
Returns an associative array, key is the ``uid``, value is the ``title``.

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups();

Alternatively, ``true`` can be used to return the complete data set for the user groups
can be returned:

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups( true );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAvailableUserGroups( $returnRowData = false )
   {
   	if (!($userGroupsByUid = $this->cache['userGroupsByUid'] ?? false)) {
   		$userGroups = \nn\t3::Db()->findAll('fe_groups');
   		$userGroupsByUid = \nn\t3::Arrays( $userGroups )->key('uid');
   		$userGroupsByUid = $this->cache['userGroupsByUid'] = $userGroupsByUid->toArray();
   	}
   	if ($returnRowData) {
   		return $userGroupsByUid;
   	}
   	return \nn\t3::Arrays($userGroupsByUid)->pluck('title')->toArray();
   }
   

