
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-login:

==============================================
FrontendUserAuthentication::login()
==============================================

\\nn\\t3::FrontendUserAuthentication()->login(``$username = '', $password = '', $startFeUserSession = true``);
----------------------------------------------

Login of an FE user using the user name and password

.. code-block:: php

	// Check credentials and start feUser session
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	
	// Check only, do not establish a feUser session
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
   

