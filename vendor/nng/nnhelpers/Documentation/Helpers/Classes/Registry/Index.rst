
.. include:: ../../../Includes.txt

.. _Registry:

==============================================
Registry
==============================================

\\nn\\t3::Registry()
----------------------------------------------

Helpful methods for registering extension components such as plugins,
backend modules, FlexForms etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Registry()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add page config

.. code-block:: php

	\nn\t3::Registry()->addPageConfig( 'test.was = 10' );
	\nn\t3::Registry()->addPageConfig( '' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

| :ref:`➜ Go to source code of Registry::addPageConfig() <Registry-addPageConfig>`

\\nn\\t3::Registry()->clearCacheHook(``$classMethodPath = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts a hook that is executed when you click on "Clear cache".
The following script is added to the ``ext_localconf.php`` of your extension:

.. code-block:: php

	\nn\t3::Registry()->clearCacheHook( \My\Ext\Path::class . '->myMethod' );

| ``@return void``

| :ref:`➜ Go to source code of Registry::clearCacheHook() <Registry-clearCacheHook>`

\\nn\\t3::Registry()->configurePlugin(``$vendorName = '', $pluginName = '', $cacheableActions = [], $uncacheableActions = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Configure a plugin.
Use in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->configurePlugin( 'Nng\Nncalendar', 'Nncalendar',
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	    [\Nng\ExtName\Controller\MainController::class => 'show']
	);

| ``@return void``

| :ref:`➜ Go to source code of Registry::configurePlugin() <Registry-configurePlugin>`

\\nn\\t3::Registry()->flexform(``$vendorName = '', $pluginName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Register a flexform for a plugin.

.. code-block:: php

	\nn\t3::Registry()->flexform( 'nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );
	\nn\t3::Registry()->flexform( 'Nng\Nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );

| ``@return void``

| :ref:`➜ Go to source code of Registry::flexform() <Registry-flexform>`

\\nn\\t3::Registry()->fluidNamespace(``$referenceNames = [], $namespaces = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Register global namespace for Fluid.
Mostly used in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->fluidNamespace( 'nn', 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], ['Nng\Nnsite\ViewHelpers', 'Other\Namespace\Fallback'] );

| ``@return void``

| :ref:`➜ Go to source code of Registry::fluidNamespace() <Registry-fluidNamespace>`

\\nn\\t3::Registry()->get(``$extName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a value from the sys_registry table.

.. code-block:: php

	\nn\t3::Registry()->get( 'nnsite', 'lastRun' );

| ``@return void``

| :ref:`➜ Go to source code of Registry::get() <Registry-get>`

\\nn\\t3::Registry()->getVendorExtensionName(``$combinedVendorPluginName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate plugin name.
Depending on the Typo3 version, the plugin name is returned with or without the vendor.

.. code-block:: php

	    \nn\t3::Registry()->getVendorExtensionName( 'nncalendar' ); // => Nng.Nncalendar
	    \nn\t3::Registry()->getVendorExtensionName( 'Nng\Nncalendar' ); // => Nng.Nncalendar

| ``@return string``

| :ref:`➜ Go to source code of Registry::getVendorExtensionName() <Registry-getVendorExtensionName>`

\\nn\\t3::Registry()->icon(``$identifier = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Register an icon. Classically used in ext_tables.php.

.. code-block:: php

	\nn\t3::Registry()->icon('nncalendar-plugin', 'EXT:myextname/Resources/Public/Icons/wizicon.svg');

| ``@return void``

| :ref:`➜ Go to source code of Registry::icon() <Registry-icon>`

\\nn\\t3::Registry()->parseControllerActions(``$controllerActionList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse list with ``'ControllerName' => 'action,list,show'``
Always specify the full class path in the ``::class`` notation.
Take into account that before Typo3 10 only the simple class name (e.g. ``Main``)
is used as the key.

.. code-block:: php

	\nn\t3::Registry()->parseControllerActions(
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	);

| ``@return array``

| :ref:`➜ Go to source code of Registry::parseControllerActions() <Registry-parseControllerActions>`

\\nn\\t3::Registry()->plugin(``$vendorName = '', $pluginName = '', $title = '', $icon = '', $tcaGroup = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Register a plugin for selection via the dropdown ``CType`` in the backend.
Use in ``Configuration/TCA/Overrides/tt_content.php`` Ã¢ or ``ext_tables.php`` (deprecated).

.. code-block:: php

	\nn\t3::Registry()->plugin( 'nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );
	\nn\t3::Registry()->plugin( 'Nng\Nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );

| ``@return void``

| :ref:`➜ Go to source code of Registry::plugin() <Registry-plugin>`

\\nn\\t3::Registry()->pluginGroup(``$vendorName = '', $groupLabel = '', $plugins = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Simplifies the registration of a list of plugins, which are combined into a group in the ``list_type`` dropdown.
group in the list_type dropdown.

Use in ``Configuration/TCA/Overrides/tt_content.php``:

.. code-block:: php

	\nn\t3::Registry()->pluginGroup(
	    'Nng\Myextname',
	    'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_group_name',
	    [
	        'list' => [
	            'title' => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_list.name',
	            'icon' => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform' => 'FILE:EXT:myextname/Configuration/FlexForm/list.xml',
	        ],
	        'show' => [
	            'title' => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_show.name',
	            'icon' => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform' => 'FILE:EXT:myextname/Configuration/FlexForm/show.xml'
	        ],
	    ]
	);

| ``@return void``

| :ref:`➜ Go to source code of Registry::pluginGroup() <Registry-pluginGroup>`

\\nn\\t3::Registry()->rootLineFields(``$fields = [], $translate = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Register a field in the pages table that is to be inherited / slid to subpages.
Register in ``ext_localconf.php``:

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['slidefield']);
	\nn\t3::Registry()->rootLineFields('slidefield');

Typoscript setup:

.. code-block:: php

	page.10 = FLUIDTEMPLATE
	page.10.variables {
	    footer = TEXT
	    footer {
	        data = levelfield:-1, footer element, slide
	    }
	}

| ``@return void``

| :ref:`➜ Go to source code of Registry::rootLineFields() <Registry-rootLineFields>`

\\nn\\t3::Registry()->set(``$extName = '', $path = '', $settings = [], $clear = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Save a value in the sys_registry table.
Data in this table is retained beyond the session.
For example, a scheduler job can save when it was last executed.
was executed.

Arrays are recursively merged / merged by default:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['one'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['two'=>'2'] );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['one'=>1, 'two'=>2]

With ``true`` at the end, the previous values are deleted:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['one'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['two'=>'2'], true );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['two'=>2]

| ``@return array``

| :ref:`➜ Go to source code of Registry::set() <Registry-set>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
