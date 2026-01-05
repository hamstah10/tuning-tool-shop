
.. include:: ../../../../Includes.txt

.. _FrontendUserAuthentication-loginField:

==============================================
FrontendUserAuthentication::loginField()
==============================================

\\nn\\t3::FrontendUserAuthentication()->loginField(``$value = NULL, $fieldName = 'uid'``);
----------------------------------------------

Login of an FE user using any field.
No password required.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginField( $value, $fieldName );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function loginField( $value = null, $fieldName = 'uid')
   {
   	if (!$value) return [];
   	$user = \nn\t3::Db()->findByValues( 'fe_users', [$fieldName => $value] );
   	if (!$user) return [];
   	if (!count($user) > 1) return [];
   	$user = array_pop($user);
   	$request = \nn\t3::Environment()->getRequest();
   	$info = $this->getAuthInfoArray($request);
   	$info['db_user']['username_column'] = 'username';
   	$feUser = $this->setSession( $user );
   	return $feUser;
   }
   

