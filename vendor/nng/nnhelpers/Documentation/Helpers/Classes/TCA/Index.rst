
.. include:: ../../../Includes.txt

.. _TCA:

==============================================
TCA
==============================================

\\nn\\t3::TCA()
----------------------------------------------

Methods for configuring and accessing fields in the TCA.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add a selection option in the page properties under "Behavior -> Contains extension".
Traditionally used in ``Configuration/TCA/Overrides/pages.php``, previously in ``ext_tables.php``

.. code-block:: php

	// Register the icon in ext_localconf.php (16 x 16 px SVG)
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('description', 'identifier', 'icon-identifier');

| ``@return void``

| :ref:`➜ Go to source code of TCA::addModuleOptionToPage() <TCA-addModuleOptionToPage>`

\\nn\\t3::TCA()->createConfig(``$tablename = '', $basics = [], $custom = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get basic configuration for the TCA.
These are the fields such as ``hidden``, ``starttime`` etc., which are always the same for (almost) all tables.

Get ALL typical fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry', true,
	    ['title'=>...]
	)

Get only certain fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry',
	    ['sys_language_uid', 'l10n_parent', 'l10n_source', 'l10n_diffsource', 'hidden', 'cruser_id', 'pid', 'crdate', 'tstamp', 'sorting', 'starttime', 'endtime', 'fe_group'],
	    ['title'=>...]
	)

| ``@return array``

| :ref:`➜ Go to source code of TCA::createConfig() <TCA-createConfig>`

\\nn\\t3::TCA()->getColorPickerTCAConfig();
"""""""""""""""""""""""""""""""""""""""""""""""

Get color picker configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),

| ``@return array``

| :ref:`➜ Go to source code of TCA::getColorPickerTCAConfig() <TCA-getColorPickerTCAConfig>`

\\nn\\t3::TCA()->getColumn(``$tableName = '', $fieldName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets configuration array for a field from the TCA.
Alias to ``\nn\t3::Db()->getColumn()``

.. code-block:: php

	\nn\t3::TCA()->getColumn( 'pages', 'media' );

| ``@return array``

| :ref:`➜ Go to source code of TCA::getColumn() <TCA-getColumn>`

\\nn\\t3::TCA()->getColumns(``$tableName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets configuration array for a table from the TCA.
Alias to ``\nn\t3::Db()->getColumns()``

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );

| ``@return array``

| :ref:`➜ Go to source code of TCA::getColumns() <TCA-getColumns>`

\\nn\\t3::TCA()->getConfig(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a configuration from the TCA for a path.
Returns a reference to the ``config array`` of the corresponding field.

.. code-block:: php

	\nn\t3::TCA()->getConfig('tt_content.columns.tx_mask_iconcollection');

| ``@return array``

| :ref:`➜ Go to source code of TCA::getConfig() <TCA-getConfig>`

\\nn\\t3::TCA()->getConfigForType(``$type = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get default configuration for various typical ``types`` in the ``TCA``
Serves as a kind of alias to write the most frequently used ``config arrays`` faster and
and to be able to write them more quickly

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'pid' ); // => ['type'=>'group', 'allowed'=>'pages', 'maxItems'=>1]
	\nn\t3::TCA()->getConfigForType( 'contentElement' ); // => ['type'=>'group', 'allowed'=>'tt_content', 'maxItems'=>1]
	\nn\t3::TCA()->getConfigForType( 'text' ); // => ['type'=>'text', 'rows'=>2, ...]
	\nn\t3::TCA()->getConfigForType( 'rte' ); // => ['type'=>'text', 'enableRichtext'=>'true', ...]
	\nn\t3::TCA()->getConfigForType( 'color' ); // => ['type'=>'color', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => ['type'=>'file', ...]

Default configurations can simply be overwritten / extended:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', ['rows'=>5] ); // => ['type'=>'text', 'rows'=>5, ...]

For each type, the most frequently overwritten value in the ``config array`` can also be
by passing a fixed value instead of an ``override array``:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'pid', 3 ); // => ['maxItems'=>3, ...]
	\nn\t3::TCA()->getConfigForType( 'contentElement', 3 ); // => ['maxItems'=>3, ...]
	\nn\t3::TCA()->getConfigForType( 'text', 10 ); // => ['rows'=>10, ...]
	\nn\t3::TCA()->getConfigForType( 'rte', 'myRteConfig' ); // => ['richtextConfiguration'=>'myRteConfig', ...]
	\nn\t3::TCA()->getConfigForType( 'color', '#ff6600' ); // => ['default'=>'#ff6600', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => [ config for the field with the key `image` ]

| ``@return array``

| :ref:`➜ Go to source code of TCA::getConfigForType() <TCA-getConfigForType>`

\\nn\\t3::TCA()->getFalFields(``$tableName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves all field names from the TCA array that have a SysFileReference relation.
For the table ``tt_content`` this would be ``assets``, ``media`` etc.

.. code-block:: php

	\nn\t3::TCA()->getFalFields( 'pages' ); // => ['media', 'assets', 'image']

| ``@return array``

| :ref:`➜ Go to source code of TCA::getFalFields() <TCA-getFalFields>`

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get FAL configuration for the TCA.

Standard config incl. image cropper, link and alternative image title
This setting changes regularly, which is quite an imposition given the number of parameters
and their changing position in the array is quite an imposition.

https://bit.ly/2SUvASe

.. code-block:: php

	\nn\t3::TCA()->getFileFieldTCAConfig('media');
	\nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);

Is used in the TCA like this:

.. code-block:: php

	'falprofileimage' => [
	    'config' => \nn\t3::TCA()->getFileFieldTCAConfig('falprofileimage', ['maxitems'=>1]),
	],

| ``@return array``

| :ref:`➜ Go to source code of TCA::getFileFieldTCAConfig() <TCA-getFileFieldTCAConfig>`

\\nn\\t3::TCA()->getRteTCAConfig();
"""""""""""""""""""""""""""""""""""""""""""""""

Get RTE configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getRteTCAConfig(),

| ``@return array``

| :ref:`➜ Go to source code of TCA::getRteTCAConfig() <TCA-getRteTCAConfig>`

\\nn\\t3::TCA()->getSlugTCAConfig(``$fields = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get default slug configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getSlugTCAConfig( 'title' )
	'config' => \nn\t3::TCA()->getSlugTCAConfig( ['title', 'header'] )

| ``@param array|string $fields``
| ``@return array``

| :ref:`➜ Go to source code of TCA::getSlugTCAConfig() <TCA-getSlugTCAConfig>`

\\nn\\t3::TCA()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts list of countries into a TCA.
Alias to \nn\t3::Flexform->insertCountries( $config, $a = null );
Description and further examples there.

Example in the TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertCountries',
	    'insertEmpty' => true,
	]

| ``@return array``

| :ref:`➜ Go to source code of TCA::insertCountries() <TCA-insertCountries>`

\\nn\\t3::TCA()->insertFlexform(``$path``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts a flex form into a TCA.

Example in the TCA:

.. code-block:: php

	'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');

| ``@return array``

| :ref:`➜ Go to source code of TCA::insertFlexform() <TCA-insertFlexform>`

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts options from TypoScript into a TCA for selection.
Alias to \nn\t3::Flexform->insertOptions( $config, $a = null );
Description and further examples there.

Example in the TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	    'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	    //'pageconfigPath' => 'tx_nnnewsroom.colors',
	]

| ``@return array``

| :ref:`➜ Go to source code of TCA::insertOptions() <TCA-insertOptions>`

\\nn\\t3::TCA()->setConfig(``$path = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Overwrite a configuration of the TCA, e.g. to overwrite a ``mask field`` with its own renderType
or to change core settings in the TCA on the ``pages`` or ``tt_content`` tables.

The following example sets/overwrites the ``config array`` in the ``TCA`` under:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['mycol']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setConfig('tt_content.columns.mycol', [
	    'renderType' => 'nnsiteIconCollection',
	    'iconconfig' => 'tx_nnsite.iconcollection',
	]);

See also ``\nn\t3::TCA()->setContentConfig()`` for a short version of this method when it comes to
the table ``tt_content`` and ``\nn\t3::TCA()->setPagesConfig()`` for the table ``pages``

| ``@return array``

| :ref:`➜ Go to source code of TCA::setConfig() <TCA-setConfig>`

\\nn\\t3::TCA()->setContentConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set or overwrite a configuration of the TCA for the table ``tt_content``.

This example overwrites the ``config array`` of the ``tt_content`` table in the ``TCA`` for:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setContentConfig( 'header', 'text' ); // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setContentConfig( 'header', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setContentConfig( 'header', ['type'=>'text', 'rows'=>10] ); // ['type'=>'text', 'rows'=>10]

| ``@return array``

| :ref:`➜ Go to source code of TCA::setContentConfig() <TCA-setContentConfig>`

\\nn\\t3::TCA()->setPagesConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set or overwrite a configuration of the TCA for the ``pages`` table.

This example overwrites the ``config array`` of the ``pages`` table for the ``TCA``:

.. code-block:: php

	$GLOBALS['TCA']['pages']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setPagesConfig( 'title', 'text' ); // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setPagesConfig( 'title', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setPagesConfig( 'title', ['type'=>'text', 'rows'=>2] ); // ['type'=>'text', 'rows'=>2]

| ``@return array``

| :ref:`➜ Go to source code of TCA::setPagesConfig() <TCA-setPagesConfig>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
