
.. include:: ../../../../Includes.txt

.. _FrontendUser-getAvailableUserGroups:

==============================================
FrontendUser::getAvailableUserGroups()
==============================================

\\nn\\t3::FrontendUser()->getAvailableUserGroups(``$returnRowData = false``);
----------------------------------------------

Alle existierende User-Gruppen zurückgeben.
Gibt ein assoziatives Array zurück, key ist die ``uid``, value der ``title``.

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups();

Alternativ kann mit ``true`` der komplette Datensatz für die Benutzergruppen
zurückgegeben werden:

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
   

