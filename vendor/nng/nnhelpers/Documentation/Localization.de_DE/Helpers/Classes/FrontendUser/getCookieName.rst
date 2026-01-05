
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCookieName:

==============================================
FrontendUser::getCookieName()
==============================================

\\nn\\t3::FrontendUser()->getCookieName();
----------------------------------------------

Cookie-Name des Frontend-User-Cookies holen.
Üblicherweise ``fe_typo_user``, außer es wurde in der LocalConfiguration geändert.

.. code-block:: php

	\nn\t3::FrontendUser()->getCookieName();

return string

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCookieName()
   {
   	if ($cookieName = $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieName'] ?? false) {
   		return $cookieName;
   	}
   	return \nn\t3::Environment()->getLocalConf('FE.cookieName');
   }
   

