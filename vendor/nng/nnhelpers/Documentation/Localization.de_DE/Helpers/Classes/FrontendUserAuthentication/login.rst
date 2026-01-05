
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-login:

==============================================
FrontendUserAuthentication::login()
==============================================

\\nn\\t3::FrontendUserAuthentication()->login(``$username = '', $password = '', $startFeUserSession = true``);
----------------------------------------------

Login eines FE-Users anhand der Usernamens und Passwortes

.. code-block:: php

	// Credentials überprüfen und feUser-Session starten
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	
	// Nur überprüfen, keine feUser-Session aufbauen
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password', false );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function login( $username = '', $password = '', $startFeUserSession = true )
   {
   	if (!trim($password) || !trim($username)) return [];
   	$user = \nn\t3::Db()->findByValues( 'fe_users', ['username'=>$username] );
   	if (!$user) return [];
   	if (count($user) > 1) return [];
   	$user = array_pop($user);
   	if (!\nn\t3::Encrypt()->checkPassword($password, $user['password'])) {
   		return [];
   	}
   	if (!$startFeUserSession) {
   		return $user;
   	}
   	$request = \nn\t3::Environment()->getRequest();
   	$info = $this->getAuthInfoArray($request);
   	$info['db_user']['username_column'] = 'username';
   	$feUser = $this->setSession( $user );
   	return $feUser;
   }
   

