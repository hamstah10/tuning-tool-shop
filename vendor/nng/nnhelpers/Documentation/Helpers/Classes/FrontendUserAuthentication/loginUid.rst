
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-loginUid:

==============================================
FrontendUserAuthentication::loginUid()
==============================================

\\nn\\t3::FrontendUserAuthentication()->loginUid(``$uid = NULL``);
----------------------------------------------

Login of an FE user using an fe_user.uid

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginUid( 1 );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function loginUid( $uid = null )
   {
   	$uid = intval($uid);
   	if (!$uid) return [];
   	$user = \nn\t3::Db()->findByUid( 'fe_users', $uid );
   	if (!$user) return [];
   	$request = \nn\t3::Environment()->getRequest();
   	$info = $this->getAuthInfoArray($request);
   	$info['db_user']['username_column'] = 'username';
   	$feUser = $this->setSession( $user );
   	return $feUser;
   }
   

