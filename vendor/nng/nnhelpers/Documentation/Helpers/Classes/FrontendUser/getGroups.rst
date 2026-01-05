
.. include:: ../../../../Includes.txt

.. _FrontendUser-getGroups:

==============================================
FrontendUser::getGroups()
==============================================

\\nn\\t3::FrontendUser()->getGroups(``$returnRowData = false``);
----------------------------------------------

Get user groups of the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUserGroups();``

.. code-block:: php

	// only load title, uid and pid of the groups
	\nn\t3::FrontendUser()->getGroups();
	// load complete data set of the groups
	\nn\t3::FrontendUser()->getGroups( true );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getGroups( $returnRowData = false )
   {
   	return $this->getCurrentUserGroups( $returnRowData );
   }
   

