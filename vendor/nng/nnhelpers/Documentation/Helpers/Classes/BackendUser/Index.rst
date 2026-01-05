
.. include:: ../../../Includes.txt

.. _BackendUser:

==============================================
BackendUser
==============================================

\\nn\\t3::BackendUser()
----------------------------------------------

Methods to check in the frontend whether a user is logged into the Typo3 backend and has admin rights, for example.
Methods to start a backend user if it does not exist (e.g. during a scheduler job).

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::BackendUser()->get();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the current backend user.
Corresponds to ``$GLOBALS['BE_USER']`` in previous Typo3 versions.

.. code-block:: php

	\nn\t3::BackendUser()->get();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

| :ref:`➜ Go to source code of BackendUser::get() <BackendUser-get>`

\\nn\\t3::BackendUser()->getCookieName();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the cookie name of the backend user cookie.
Usually ``be_typo_user``, unless it has been changed in the LocalConfiguration.

.. code-block:: php

	\nn\t3::BackendUser()->getCookieName();

return string

| :ref:`➜ Go to source code of BackendUser::getCookieName() <BackendUser-getCookieName>`

\\nn\\t3::BackendUser()->getSettings(``$moduleName = 'nnhelpers', $path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves user-specific settings for the currently logged in backend user.
See ``\nn\t3::BackendUser()->updateSettings()`` to save the data.

.. code-block:: php

	\nn\t3::BackendUser()->getSettings('myext'); // => ['wants'=>['drink'=>'coffee']]
	\nn\t3::BackendUser()->getSettings('myext', 'wants'); // => ['drink'=>'coffee']
	\nn\t3::BackendUser()->getSettings('myext', 'wants.drink'); // => 'coffee'

| ``@return mixed``

| :ref:`➜ Go to source code of BackendUser::getSettings() <BackendUser-getSettings>`

\\nn\\t3::BackendUser()->isAdmin();
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the BE user is an admin.
Earlier: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isAdmin();

| ``@return bool``

| :ref:`➜ Go to source code of BackendUser::isAdmin() <BackendUser-isAdmin>`

\\nn\\t3::BackendUser()->isLoggedIn(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether a BE user is logged in.
Example: Only show certain content in the frontend if the user is logged in in the backend.
Previously: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	// Check after complete initialization of the front/backend
	\nn\t3::BackendUser()->isLoggedIn();
	
	// Check using the JWT, e.g. in an eID script before authentication
	\nn\t3::BackendUser()->isLoggedIn( $request );

| ``@param ServerRequest $request``
| ``@return bool``

| :ref:`➜ Go to source code of BackendUser::isLoggedIn() <BackendUser-isLoggedIn>`

\\nn\\t3::BackendUser()->start();
"""""""""""""""""""""""""""""""""""""""""""""""

Start (fake) backend user.
Solves the problem that, for example, certain functions from the scheduler
such as ``log()`` are not possible if there is no active BE user.

.. code-block:: php

	\nn\t3::BackendUser()->start();

| ``@return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication``

| :ref:`➜ Go to source code of BackendUser::start() <BackendUser-start>`

\\nn\\t3::BackendUser()->updateSettings(``$moduleName = 'nnhelpers', $settings = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Saves user-specific settings for the currently logged in backend user.
These settings are also available again for the user after logout/login.
See ``\nn\t3::BackendUser()->getSettings('myext')`` to read the data.

.. code-block:: php

	\nn\t3::BackendUser()->updateSettings('myext', ['wants'=>['drink'=>'coffee']]);

| ``@return array``

| :ref:`➜ Go to source code of BackendUser::updateSettings() <BackendUser-updateSettings>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
