
.. include:: ../../../../Includes.txt

.. _BackendUser-getCookieName:

==============================================
BackendUser::getCookieName()
==============================================

\\nn\\t3::BackendUser()->getCookieName();
----------------------------------------------

Get the cookie name of the backend user cookie.
Usually ``be_typo_user``, unless it has been changed in the LocalConfiguration.

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
   

