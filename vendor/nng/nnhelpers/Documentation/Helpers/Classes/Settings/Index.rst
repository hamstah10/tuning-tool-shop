
.. include:: ../../../Includes.txt

.. _Settings:

==============================================
Settings
==============================================

\\nn\\t3::Settings()
----------------------------------------------

methods to simplify access to TypoScript setup, constants and PageTsConfig
to simplify access.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Settings()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add page config
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::Settings()->addPageConfig( 'test.was = 10' );
	\nn\t3::Settings()->addPageConfig( '' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

| :ref:`➜ Go to source code of Settings::addPageConfig() <Settings-addPageConfig>`

\\nn\\t3::Settings()->get(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fetches the TypoScript setup and the "settings" section there.
Values from the FlexForm are not merged.
Alias to ``\nn\t3::Settings()->getSettings()``.

.. code-block:: php

	\nn\t3::Settings()->get( 'nnsite' );
	\nn\t3::Settings()->get( 'nnsite', 'path.in.settings' );

| ``@return array``

| :ref:`➜ Go to source code of Settings::get() <Settings-get>`

\\nn\\t3::Settings()->getCachedTyposcript();
"""""""""""""""""""""""""""""""""""""""""""""""

High-performance version for initializing the TSFE in the backend.
Get the complete TypoScript setup, incl. '.' syntax.

Is saved via file cache.

.. code-block:: php

	\nn\t3::Settings()->getCachedTyposcript();

| ``@return array``

| :ref:`➜ Go to source code of Settings::getCachedTyposcript() <Settings-getCachedTyposcript>`

\\nn\\t3::Settings()->getConstants(``$tsPath = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get array of TypoScript constants.

.. code-block:: php

	\nn\t3::Settings()->getConstants();
	\nn\t3::Settings()->getConstants('path.to.constant');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.constants(path:'path.to.constant')}

| ``@return array``

| :ref:`➜ Go to source code of Settings::getConstants() <Settings-getConstants>`

\\nn\\t3::Settings()->getExtConf(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get extension configuration.
come from the ``LocalConfiguration.php``, are defined via the extension settings
defined in the backend or ``ext_conf_template.txt`` 

Earlier: ``$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']``

.. code-block:: php

	\nn\t3::Settings()->getExtConf( 'extname' );

| ``@return mixed``

| :ref:`➜ Go to source code of Settings::getExtConf() <Settings-getExtConf>`

\\nn\\t3::Settings()->getFromPath(``$tsPath = '', $setup = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get setup from a given path, e.g. 'plugin.tx_example.settings'

.. code-block:: php

	\nn\t3::Settings()->getFromPath('plugin.path');
	\nn\t3::Settings()->getFromPath('L', \nn\t3::Request()->GP());
	\nn\t3::Settings()->getFromPath('a.b', ['a'=>['b'=>1]]);

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.setup(path:'path.zur.setup')}

| ``@return array``

| :ref:`➜ Go to source code of Settings::getFromPath() <Settings-getFromPath>`

\\nn\\t3::Settings()->getFullTypoScriptFromConfigurationManager();
"""""""""""""""""""""""""""""""""""""""""""""""

Get complete TypoScript via the Configuration Manager.

A simple wrapper for the core function but with ``try { ... } catch()``
Fallback.

Does not work in every context - e.g. not in the CLI context!
Better: ``\nn\t3::Settings()->parseTypoScriptForPage();`` use.

Returns the notation with dots. This can be done via
| ``\nn\t3::TypoScript()->convertToPlainArray()`` into a normal`` array``
be converted into a normal array.

.. code-block:: php

	// ==> ['plugin.']['example.'][...]
	$setup = \nn\t3::Settings()->getFullTypoScriptFromConfigurationManager();

| ``@return array``

| :ref:`➜ Go to source code of Settings::getFullTypoScriptFromConfigurationManager() <Settings-getFullTypoScriptFromConfigurationManager>`

\\nn\\t3::Settings()->getFullTyposcript(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the complete TypoScript setup, as a simple array - without "." syntax
Works both in the frontend and backend, with and without passed pid

.. code-block:: php

	\nn\t3::Settings()->getFullTyposcript();
	\nn\t3::Settings()->getFullTyposcript( $pid );

| ``@return array``

| :ref:`➜ Go to source code of Settings::getFullTyposcript() <Settings-getFullTyposcript>`

\\nn\\t3::Settings()->getMergedSettings(``$extensionName = NULL, $ttContentUidOrSetupArray = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get merge from TypoScript setup for a plugin and its flexform.
Returns the TypoScript array from ``plugin.tx_extname.settings.``.. back.

Important: Only specify $extensionName if the setup of a FREMDEN extension
is to be fetched or there is no controller context because the
call is made from the backend... otherwise the FlexForm values are not taken into account!

In the FlexForm ```` use!
| ```` Then overwrite ``settings.varName`` in the TypoScript setup

| ``$ttContentUidOrSetupArray`` can be the uid of a ``tt_content content element``
or a simple array to overwrite the values from the TypoScript / FlexForm

.. code-block:: php

	\nn\t3::Settings()->getMergedSettings();
	\nn\t3::Settings()->getMergedSettings( 'nnsite' );
	\nn\t3::Settings()->getMergedSettings( $extensionName, $ttContentUidOrSetupArray );

| ``@return array``

| :ref:`➜ Go to source code of Settings::getMergedSettings() <Settings-getMergedSettings>`

\\nn\\t3::Settings()->getPageConfig(``$tsPath = '', $pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get page configuration

.. code-block:: php

	\nn\t3::Settings()->getPageConfig();
	\nn\t3::Settings()->getPageConfig('RTE.default.preset');
	\nn\t3::Settings()->getPageConfig( $tsPath, $pid );

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.page(path:'path.to.pageconfig')}

| ``@return array``

| :ref:`➜ Go to source code of Settings::getPageConfig() <Settings-getPageConfig>`

\\nn\\t3::Settings()->getPlugin(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the setup for a specific plugin.

.. code-block:: php

	\nn\t3::Settings()->getPlugin('extname') returns TypoScript from plugin.tx_extname...

Important: Only specify $extensionName if the setup of a FREMDEN extension
is to be fetched or there is no controller context because the call is made e.g.
is made from the backend

| ``@return array``

| :ref:`➜ Go to source code of Settings::getPlugin() <Settings-getPlugin>`

\\nn\\t3::Settings()->getSettings(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fetches the TypoScript setup and the "settings" section there.
Values from the FlexForm are not merged.

.. code-block:: php

	\nn\t3::Settings()->getSettings( 'nnsite' );
	\nn\t3::Settings()->getSettings( 'nnsite', 'example.path' );

| ``@return array``

| :ref:`➜ Go to source code of Settings::getSettings() <Settings-getSettings>`

\\nn\\t3::Settings()->getSiteConfig(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get site configuration.
This is the configuration that has been defined in the YAML files in the ``/sites`` folder since TYPO3 9.
Some of the settings can also be set via the "Sites" page module.

In the context of a MiddleWare, the ``site`` may not yet be parsed / loaded.
In this case, the ``$request`` from the MiddleWare can be passed to determine the site.

.. code-block:: php

	$config = \nn\t3::Settings()->getSiteConfig();
	$config = \nn\t3::Settings()->getSiteConfig( $request );

| ``@return array``

| :ref:`➜ Go to source code of Settings::getSiteConfig() <Settings-getSiteConfig>`

\\nn\\t3::Settings()->getStoragePid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get current (FIRST) StoragePid for the current plugin.
Saved in the TypoScript setup of the extension under
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm
only happens if ``$extName``is left `` empty``.

.. code-block:: php

	\nn\t3::Settings()->getStoragePid(); // 123
	\nn\t3::Settings()->getStoragePid('nnsite'); // 466

| ``@return string``

| :ref:`➜ Go to source code of Settings::getStoragePid() <Settings-getStoragePid>`

\\nn\\t3::Settings()->getStoragePids(``$extName = NULL, $recursive = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get ALL storagePids for the current plugin.
Saved as a comma-separated list in the TypoScript setup of the extension under
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm
only happens if ``$extName``is left `` empty``.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(); // [123, 466]
	\nn\t3::Settings()->getStoragePids('nnsite'); // [123, 466]

Also get the child-PageUids?
| ``true`` takes the value for "Recursive" from the FlexForm or from the
TypoScript of the extension of ``plugin.tx_extname.persistence.recursive``

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(true); // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', true); // [123, 466, 124, 467, 468]

Alternatively, a numerical value can also be passed for the depth / recursion
can also be passed.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(2); // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', 2); // [123, 466, 124, 467, 468]

| ``@return array``

| :ref:`➜ Go to source code of Settings::getStoragePids() <Settings-getStoragePids>`

\\nn\\t3::Settings()->parseTypoScriptForPage(``$pageUid = 0, $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse TypoScript for specific pageUid.

Returns the notation with dots. This can be done via
| ``\nn\t3::TypoScript()->convertToPlainArray()`` into a normal`` array``
be converted into a normal array.

.. code-block:: php

	// Get TypoScript for current pageUid
	\nn\t3::Settings()->parseTypoScriptForPage();
	
	// Get TypoScript for specific pageUid
	\nn\t3::Settings()->parseTypoScriptForPage(123);

| ``@param int $pid`` PageUid
| ``@param ServerRequestInterface $request``
| ``@return array``

| :ref:`➜ Go to source code of Settings::parseTypoScriptForPage() <Settings-parseTypoScriptForPage>`

\\nn\\t3::Settings()->setExtConf(``$extName = '', $key = '', $value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write extension configuration.
Writes an extension configuration in the ``LocalConfiguration.php.`` The values can also be
corresponding configuration in ``ext_conf_template.txt``, the values can also be edited via the Extension Manager / the
Extension configuration in the backend.

.. code-block:: php

	\nn\t3::Settings()->setExtConf( 'extname', 'key', 'value' );

| ``@return mixed``

| :ref:`➜ Go to source code of Settings::setExtConf() <Settings-setExtConf>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
