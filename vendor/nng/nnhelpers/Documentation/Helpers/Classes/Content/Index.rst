
.. include:: ../../../Includes.txt

.. _Content:

==============================================
Content
==============================================

\\nn\\t3::Content()
----------------------------------------------

Read and render content elements and content of a backend column``(colPos``)

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Content()->addRelations(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Loads relations``(media``, ``assets``, ...) to a ``tt_content data array``
If ``EXT:mask`` is installed, the corresponding method from mask is used.

.. code-block:: php

	\nn\t3::Content()->addRelations( $data );

| ``@return array``

| :ref:`➜ Go to source code of Content::addRelations() <Content-addRelations>`

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL, $slide = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Loads the content for a specific column``(colPos``) and page.
If no pageUid is specified, it uses the current page.
With ``slide``, the content element of the parent page is fetched if no content element exists in the column on the specified page.

Get content of ``colPos = 110`` from the current page:

.. code-block:: php

	\nn\t3::Content()->column( 110 );

Get content of ``colPos = 110`` from the current page. If there is no content in the column on the current page, use the content from the parent page:

.. code-block:: php

	\nn\t3::Content()->column( 110, true );

Get the content of ``colPos = 110`` from the page with id ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99 );

Get content of ``colPos = 110`` from the page with id ``99``. If there is no content in the column on page ``99``, use the content from the parent page of page ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99, true );

Also available as ViewHelper:

.. code-block:: php

	{nnt3:content.column(colPos:110)}
	{nnt3:content.column(colPos:110, slide:1)}
	{nnt3:content.column(colPos:110, pid:99)}
	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

| :ref:`➜ Go to source code of Content::column() <Content-column>`

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Loads the "raw" ``tt_content`` data of a specific column``(colPos``).

.. code-block:: php

	\nn\t3::Content()->columnData( 110 );
	\nn\t3::Content()->columnData( 110, true );
	\nn\t3::Content()->columnData( 110, true, 99 );

Also available as ViewHelper.
| ``relations`` is set to ``TRUE`` by default in the ViewHelper

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

| :ref:`➜ Go to source code of Content::columnData() <Content-columnData>`

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false, $localize = true, $field = 'uid'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Loads the data of a tt_content element as a simple array:

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Loading relations``(media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

Translations / Localization:

Do NOT automatically translate element if a different language has been set

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, false );

Get element in a DIFFERENT language than set in the frontend.
Takes into account the fallback chain of the language that was set in the site config

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, 2 );

Get element with its own fallback chain. Completely ignores the chain,
that was defined in the site config.

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, [2,3,0] );

Use your own field for recognition

.. code-block:: php

	\nn\t3::Content()->get( 'footer', true, true, 'content_uuid' );

| ``@param int|string $ttContentUid`` Content-Uid in the table tt_content (or string with a key)
| ``@param bool $getRelations`` Also get relations / FAL?
| ``@param bool $localize`` Translate the entry?
| ``@param string $localize`` Translate the entry?
| ``@param string $field`` If field other than ``uid`` is to be used
| ``@return array``

| :ref:`➜ Go to source code of Content::get() <Content-get>`

\\nn\\t3::Content()->getAll(``$constraints = [], $getRelations = false, $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get multiple content elements (from ``tt_content``).

The data records are localized automatically - except ``$localize`` is set to ``false``
is set to false. See ``\nn\t3::Content()->get()`` for more ``$localize`` options.

Based on a list of UIDs:

.. code-block:: php

	\nn\t3::Content()->getAll( 1 );
	\nn\t3::Content()->getAll( [1, 2, 7] );

Based on filter criteria:

.. code-block:: php

	\nn\t3::Content()->getAll( ['pid'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'colPos'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'CType'=>'mask_section_cards', 'colPos'=>1] );

| ``@param mixed $ttContentUid`` Content-Uids or constraints for querying the data
| ``@param bool $getRelations`` Also get relations / FAL?
| ``@param bool $localize`` Translate the entry?
| ``@return array``

| :ref:`➜ Go to source code of Content::getAll() <Content-getAll>`

\\nn\\t3::Content()->localize(``$table = 'tt_content', $data = [], $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Localize / translate data.

Examples:

Translate data using the current language of the frontend.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data );

Get data in a DIFFERENT language than the one set in the frontend.
Takes into account the fallback chain of the language that was set in the site config

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, 2 );

Get data with own fallback chain. Completely ignores the chain,
that was defined in the site config.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );

| ``@param string $table`` Database table
| ``@param array $data`` Array with the data of the default language (languageUid = 0)
| ``@param mixed $localize`` Specification of how to translate. Boolean, uid or array with uids
| ``@return array``

| :ref:`➜ Go to source code of Content::localize() <Content-localize>`

\\nn\\t3::Content()->render(``$ttContentUid = NULL, $data = [], $field = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Renders a ``tt_content element`` as HTML

.. code-block:: php

	\nn\t3::Content()->render( 1201 );
	\nn\t3::Content()->render( 1201, ['key'=>'value'] );
	\nn\t3::Content()->render( 'footer', ['key'=>'value'], 'content_uuid' );

Also available as ViewHelper:

.. code-block:: php

	{nnt3:contentElement(uid:123, data:feUser.data)}
	{nnt3:contentElement(uid:'footer', field:'content_uuid')}

| ``@return string``

| :ref:`➜ Go to source code of Content::render() <Content-render>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
