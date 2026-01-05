
.. include:: ../../../../Includes.txt

.. _FrontendUser-getGroups:

==============================================
FrontendUser::getGroups()
==============================================

\\nn\\t3::FrontendUser()->getGroups(``$returnRowData = false``);
----------------------------------------------

Benutzergruppen des aktuellen FE-User holen.
Alias zu ``\nn\t3::FrontendUser()->getCurrentUserGroups();``

.. code-block:: php

	// nur title, uid und pid der Gruppen laden
	\nn\t3::FrontendUser()->getGroups();
	// kompletten Datensatz der Gruppen laden
	\nn\t3::FrontendUser()->getGroups( true );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getGroups( $returnRowData = false )
   {
   	return $this->getCurrentUserGroups( $returnRowData );
   }
   

