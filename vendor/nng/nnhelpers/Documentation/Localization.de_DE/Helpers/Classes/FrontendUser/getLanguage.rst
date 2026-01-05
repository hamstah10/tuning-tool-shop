
.. include:: ../../../../Includes.txt

.. _FrontendUser-getLanguage:

==============================================
FrontendUser::getLanguage()
==============================================

\\nn\\t3::FrontendUser()->getLanguage();
----------------------------------------------

Sprach-UID des aktuellen Users holen

.. code-block:: php

	$languageUid = \nn\t3::FrontendUser()->getLanguage();

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLanguage()
   {
   	return \nn\t3::Environment()->getLanguage();
   }
   

