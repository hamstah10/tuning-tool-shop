
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCookieName:

==============================================
FrontendUser::getCookieName()
==============================================

\\nn\\t3::FrontendUser()->getCookieName();
----------------------------------------------

Get the cookie name of the frontend user cookie.
Usually ``fe_typo_user``, unless it has been changed in the LocalConfiguration.

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
   

