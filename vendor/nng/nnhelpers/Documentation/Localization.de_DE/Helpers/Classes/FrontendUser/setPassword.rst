
.. include:: ../../../../Includes.txt

.. _FrontendUser-setPassword:

==============================================
FrontendUser::setPassword()
==============================================

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
----------------------------------------------

Passwort eines FE-Users ändern.
Alias zu ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123passwort$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123Passwort#$' );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setPassword( $feUserUid = null, $password = null )
   {
   	return \nn\t3::FrontendUserAuthentication()->setPassword( $feUserUid, $password );
   }
   

