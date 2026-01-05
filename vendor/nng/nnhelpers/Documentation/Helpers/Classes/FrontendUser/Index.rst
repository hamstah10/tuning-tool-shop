
.. include:: ../../../Includes.txt

.. _FrontendUser:

==============================================
FrontendUser
==============================================

\\nn\\t3::FrontendUser()
----------------------------------------------

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUser()->get();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUser();``

.. code-block:: php

	\nn\t3::FrontendUser()->get();

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::get() <FrontendUser-get>`

\\nn\\t3::FrontendUser()->getAvailableUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Return all existing user groups.
Returns an associative array, key is the ``uid``, value is the ``title``.

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups();

Alternatively, ``true`` can be used to return the complete data set for the user groups
can be returned:

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups( true );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::getAvailableUserGroups() <FrontendUser-getAvailableUserGroups>`

\\nn\\t3::FrontendUser()->getCookie();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the current ``fe_typo_user`` cookie.

.. code-block:: php

	$cookie = \nn\t3::FrontendUser()->getCookie();

| ``@return string``

| :ref:`➜ Go to source code of FrontendUser::getCookie() <FrontendUser-getCookie>`

\\nn\\t3::FrontendUser()->getCookieName();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the cookie name of the frontend user cookie.
Usually ``fe_typo_user``, unless it has been changed in the LocalConfiguration.

.. code-block:: php

	\nn\t3::FrontendUser()->getCookieName();

return string

| :ref:`➜ Go to source code of FrontendUser::getCookieName() <FrontendUser-getCookieName>`

\\nn\\t3::FrontendUser()->getCurrentUser();
"""""""""""""""""""""""""""""""""""""""""""""""

Get array with the data of the current FE user.

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUser();

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::getCurrentUser() <FrontendUser-getCurrentUser>`

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get user groups of the current FE user as an array.
The uids of the user groups are used as keys in the returned array.

.. code-block:: php

	// Minimal version: By default, Typo3 only returns title, uid and pid
	\nn\t3::FrontendUser()->getCurrentUserGroups(); // [1 => ['title'=>'Group A', 'uid' => 1, 'pid'=>5]]
	
	// If true, the complete data record for the fe_user_group can be read from the DB
	\nn\t3::FrontendUser()->getCurrentUserGroups( true ); // [1 => [... all fields of the DB] ]

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::getCurrentUserGroups() <FrontendUser-getCurrentUserGroups>`

\\nn\\t3::FrontendUser()->getCurrentUserUid();
"""""""""""""""""""""""""""""""""""""""""""""""

Get UID of the current frontend user

.. code-block:: php

	$uid = \nn\t3::FrontendUser()->getCurrentUserUid();

| ``@return int``

| :ref:`➜ Go to source code of FrontendUser::getCurrentUserUid() <FrontendUser-getCurrentUserUid>`

\\nn\\t3::FrontendUser()->getGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get user groups of the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUserGroups();``

.. code-block:: php

	// only load title, uid and pid of the groups
	\nn\t3::FrontendUser()->getGroups();
	// load complete data set of the groups
	\nn\t3::FrontendUser()->getGroups( true );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::getGroups() <FrontendUser-getGroups>`

\\nn\\t3::FrontendUser()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Get language UID of the current user

.. code-block:: php

	$languageUid = \nn\t3::FrontendUser()->getLanguage();

| ``@return int``

| :ref:`➜ Go to source code of FrontendUser::getLanguage() <FrontendUser-getLanguage>`

\\nn\\t3::FrontendUser()->getSession();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current user session.

.. code-block:: php

	\nn\t3::FrontendUser()->getSession();

| ``@return \TYPO3\CMS\Core\Session\UserSession``

| :ref:`➜ Go to source code of FrontendUser::getSession() <FrontendUser-getSession>`

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get session data for FE users

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('store')

| ``@return mixed``

| :ref:`➜ Go to source code of FrontendUser::getSessionData() <FrontendUser-getSessionData>`

\\nn\\t3::FrontendUser()->getSessionId();
"""""""""""""""""""""""""""""""""""""""""""""""

Get session ID of the current frontend user

.. code-block:: php

	$sessionId = \nn\t3::FrontendUser()->getSessionId();

| ``@return string``

| :ref:`➜ Go to source code of FrontendUser::getSessionId() <FrontendUser-getSessionId>`

\\nn\\t3::FrontendUser()->hasRole(``$roleUid``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the user has a specific role.

.. code-block:: php

	\nn\t3::FrontendUser()->hasRole( $roleUid );

| ``@param $role``
| ``@return bool``

| :ref:`➜ Go to source code of FrontendUser::hasRole() <FrontendUser-hasRole>`

\\nn\\t3::FrontendUser()->isInUserGroup(``$feGroups = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the current frontend user is within a specific user group.

.. code-block:: php

	\nn\t3::FrontendUser()->isInUserGroup( 1 );
	\nn\t3::FrontendUser()->isInUserGroup( ObjectStorage );
	\nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	\nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );

| ``@return boolean``

| :ref:`➜ Go to source code of FrontendUser::isInUserGroup() <FrontendUser-isInUserGroup>`

\\nn\\t3::FrontendUser()->isLoggedIn(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the user is currently logged in as a FE user.
Earlier: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser

.. code-block:: php

	// Check after complete initialization of the front/backend
	\nn\t3::FrontendUser()->isLoggedIn();
	
	// Check using the JWT, e.g. in an eID script before authentication
	\nn\t3::FrontendUser()->isLoggedIn( $request );

| ``@param ServerRequest $request``
| ``@return boolean``

| :ref:`➜ Go to source code of FrontendUser::isLoggedIn() <FrontendUser-isLoggedIn>`

\\nn\\t3::FrontendUser()->login(``$username, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Log in user manually.
from v10: Alias to ``\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );``

.. code-block:: php

	\nn\t3::FrontendUser()->login('99grad');

| ``@param $username``
| ``@param $password``
@throws \ReflectionException

| :ref:`➜ Go to source code of FrontendUser::login() <FrontendUser-login>`

\\nn\\t3::FrontendUser()->logout();
"""""""""""""""""""""""""""""""""""""""""""""""

Log out the current FE-USer manually

.. code-block:: php

	\nn\t3::FrontendUser()->logout();

| ``@return void``

| :ref:`➜ Go to source code of FrontendUser::logout() <FrontendUser-logout>`

\\nn\\t3::FrontendUser()->removeCookie();
"""""""""""""""""""""""""""""""""""""""""""""""

Manually delete the current ``fe_typo_user cookie``

.. code-block:: php

	\nn\t3::FrontendUser()->removeCookie()

| ``@return void``

| :ref:`➜ Go to source code of FrontendUser::removeCookie() <FrontendUser-removeCookie>`

\\nn\\t3::FrontendUser()->resolveUserGroups(``$arr = [], $ignoreUids = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts an array or a comma-separated list with user group UIDs into
| ``fe_user_groups data`` from the database. Checks for inherited subgroup.

.. code-block:: php

	\nn\t3::FrontendUser()->resolveUserGroups( [1,2,3] );
	\nn\t3::FrontendUser()->resolveUserGroups( '1,2,3' );

| ``@return array``

| :ref:`➜ Go to source code of FrontendUser::resolveUserGroups() <FrontendUser-resolveUserGroups>`

\\nn\\t3::FrontendUser()->setCookie(``$sessionId = NULL, $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set the ``fe_typo_user cookie`` manually.

If no ``sessionID`` is passed, Typo3 searches for the FE user's session ID itself.

When calling this method from a MiddleWare, the ``request`` should be passed with .
This allows, for example, the global ``$_COOKIE value`` and the ``cookieParams.fe_typo_user`` in the request
before authentication via ``typo3/cms-frontend/authentication`` in a separate MiddleWare
must be set. Helpful if cross-domain authentication is required (e.g.
via Json Web Token / JWT).

.. code-block:: php

	\nn\t3::FrontendUser()->setCookie();
	\nn\t3::FrontendUser()->setCookie( $sessionId );
	\nn\t3::FrontendUser()->setCookie( $sessionId, $request );

| ``@return void``

| :ref:`➜ Go to source code of FrontendUser::setCookie() <FrontendUser-setCookie>`

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change the password of an FE user.
Alias to ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123password$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123Password#$' );

| ``@return boolean``

| :ref:`➜ Go to source code of FrontendUser::setPassword() <FrontendUser-setPassword>`

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set session data for FE user

.. code-block:: php

	// Merge session data for `shop` with new data (existing keys in `shop` are not deleted)
	\nn\t3::FrontendUser()->setSessionData('store', ['a'=>1]);
	
	// Overwrite session data for `shop` (`a` from the example above is deleted)
	\nn\t3::FrontendUser()->setSessionData('store', ['b'=>1], false);

| ``@return mixed``

| :ref:`➜ Go to source code of FrontendUser::setSessionData() <FrontendUser-setSessionData>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
