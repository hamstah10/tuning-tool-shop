
.. include:: ../../../../Includes.txt

.. _FrontendUser-setPassword:

==============================================
FrontendUser::setPassword()
==============================================

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
----------------------------------------------

Change the password of an FE user.
Alias to ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123password$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123Password#$' );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setPassword( $feUserUid = null, $password = null )
   {
   	return \nn\t3::FrontendUserAuthentication()->setPassword( $feUserUid, $password );
   }
   

