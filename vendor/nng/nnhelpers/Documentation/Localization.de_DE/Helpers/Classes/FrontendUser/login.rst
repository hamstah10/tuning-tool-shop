
.. include:: ../../../../Includes.txt

.. _FrontendUser-login:

==============================================
FrontendUser::login()
==============================================

\\nn\\t3::FrontendUser()->login(``$username, $password = NULL``);
----------------------------------------------

User manuell einloggen.
ab v10: Alias zu ``\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );``

.. code-block:: php

	\nn\t3::FrontendUser()->login('99grad');

| ``@param $username``
| ``@param $password``
@throws \ReflectionException

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function login( $username, $password = null )
   {
   	if ($password !== null) {
   		die('Please use \nn\t3::FrontendUserAuthentication()->login()');
   	}
   	$user = \nn\t3::FrontendUserAuthentication()->loginByUsername( $username );
   	return $user ?: [];
   }
   

