
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-loginByUsername:

==============================================
FrontendUserAuthentication::loginByUsername()
==============================================

\\nn\\t3::FrontendUserAuthentication()->loginByUsername(``$username = ''``);
----------------------------------------------

Login of an FE user based on the user name

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginByUsername( '99grad' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function loginByUsername( $username = '' )
   {
   	if (!trim($username)) return [];
   	$user = \nn\t3::Db()->findByValues( 'fe_users', ['username'=>$username] );
   	if (!$user) return [];
   	if (count($user) > 1) return [];
   	$user = $user[0];
   	$request = \nn\t3::Environment()->getRequest();
   	$info = $this->getAuthInfoArray($request);
   	$info['db_user']['username_column'] = 'username';
   	$feUser = $this->setSession( $user );
   	return $feUser;
   }
   

