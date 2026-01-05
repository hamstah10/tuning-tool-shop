
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-setPassword:

==============================================
FrontendUserAuthentication::setPassword()
==============================================

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
----------------------------------------------

Passwort eines FE-Users ändern.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Passwort#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Passwort#$' );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setPassword( $feUserUid = null, $password = null )
   {
   	if (!$password || !$feUserUid) return false;
   	if (!is_numeric($feUserUid)) $feUserUid = \nn\t3::Obj()->get( $feUserUid, 'uid' );
   	$saltedPassword = \nn\t3::Encrypt()->password( $password );
   	\nn\t3::Db()->update( 'fe_users', [
   		'password' => $saltedPassword,
   		'pwchanged' => time(),
   	], $feUserUid);
   	return true;
   }
   

