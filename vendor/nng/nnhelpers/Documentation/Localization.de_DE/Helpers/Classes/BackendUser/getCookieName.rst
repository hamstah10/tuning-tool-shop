
.. include:: ../../../../Includes.txt

.. _BackendUser-getCookieName:

==============================================
BackendUser::getCookieName()
==============================================

\\nn\\t3::BackendUser()->getCookieName();
----------------------------------------------

Cookie-Name des Backend-User-Cookies holen.
Üblicherweise ``be_typo_user``, außer es wurde in der LocalConfiguration geändert.

.. code-block:: php

	\nn\t3::BackendUser()->getCookieName();

return string

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCookieName()
   {
   	if ($cookieName = $GLOBALS['TYPO3_CONF_VARS']['BE']['cookieName'] ?? 'be_typo_user') {
   		return $cookieName;
   	}
   	return \nn\t3::Environment()->getLocalConf('BE.cookieName');
   }
   

