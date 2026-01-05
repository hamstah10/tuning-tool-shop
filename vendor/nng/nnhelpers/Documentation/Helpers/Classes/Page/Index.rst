
.. include:: ../../../Includes.txt

.. _Page:

==============================================
Page
==============================================

\\nn\\t3::Page()
----------------------------------------------

Everything about the ``pages`` table.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Page()->addCssFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS file in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addCss( 'path/to/style.css' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addCssFile() <Page-addCssFile>`

\\nn\\t3::Page()->addCssLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS library in ```` inject

.. code-block:: php

	\nn\t3::Page()->addCssLibrary( 'path/to/style.css' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addCssLibrary() <Page-addCssLibrary>`

\\nn\\t3::Page()->addFooter(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Append CSS or JS or HTML code to the footer.
Decide for yourself which PageRender method to use.

.. code-block:: php

	\nn\t3::Page()->addFooter( 'fileadmin/style.css' );
	\nn\t3::Page()->addFooter( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addFooter( 'js/script.js' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addFooter() <Page-addFooter>`

\\nn\\t3::Page()->addFooterData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

HTML code before the end of the `` inject
See \nn\t3::Page()->addFooter() for simpler version.

.. code-block:: php

	\nn\t3::Page()->addFooterData( '' );

@return void``

| :ref:`➜ Go to source code of Page::addFooterData() <Page-addFooterData>`

\\nn\\t3::Page()->addHeader(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Append CSS or JS or HTML code to the footer.
Decide for yourself which PageRender method to use.

.. code-block:: php

	\nn\t3::Page()->addHeader( 'fileadmin/style.css' );
	\nn\t3::Page()->addHeader( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addHeader( 'js/script.js' );
	\nn\t3::Page()->addHeader('....');

| ``@return void``

| :ref:`➜ Go to source code of Page::addHeader() <Page-addHeader>`

\\nn\\t3::Page()->addHeaderData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

HTML code in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addHeaderData( '' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addHeaderData() <Page-addHeaderData>`

\\nn\\t3::Page()->addJsFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS file in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFile( 'path/to/file.js' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addJsFile() <Page-addJsFile>`

\\nn\\t3::Page()->addJsFooterFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS file at the end of the `` inject
See \nn\t3::Page()->addJsFooterFile() for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFooterFile( 'path/to/file.js' );

@return void``

| :ref:`➜ Go to source code of Page::addJsFooterFile() <Page-addJsFooterFile>`

\\nn\\t3::Page()->addJsFooterLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS library at the end of the `` inject

.. code-block:: php

	\nn\t3::Page()->addJsFooterLibrary( 'path/to/file.js' );

@return void``

| :ref:`➜ Go to source code of Page::addJsFooterLibrary() <Page-addJsFooterLibrary>`

\\nn\\t3::Page()->addJsLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS library in ```` inject.

.. code-block:: php

	\nn\t3::Page()->addJsLibrary( 'path/to/file.js' );

| ``@return void``

| :ref:`➜ Go to source code of Page::addJsLibrary() <Page-addJsLibrary>`

\\nn\\t3::Page()->clearCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Delete the page cache of one (or more) pages

.. code-block:: php

	\nn\t3::Page()->clearCache( $pid );
	\nn\t3::Page()->clearCache( [1,2,3] );
	\nn\t3::Page()->clearCache();

| ``@return void``

| :ref:`➜ Go to source code of Page::clearCache() <Page-clearCache>`

\\nn\\t3::Page()->get(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get data of a page (from table "pages")

.. code-block:: php

	\nn\t3::Page()->get( $uid );

| ``@return array``

| :ref:`➜ Go to source code of Page::get() <Page-get>`

\\nn\\t3::Page()->getAbsLink(``$pidOrParams = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate an absolute link to a page

.. code-block:: php

	\nn\t3::Page()->getAbsLink( $pid );
	\nn\t3::Page()->getAbsLink( $pid, ['type'=>'232322'] );
	\nn\t3::Page()->getAbsLink( ['type'=>'232322'] );

| ``@return string``

| :ref:`➜ Go to source code of Page::getAbsLink() <Page-getAbsLink>`

\\nn\\t3::Page()->getActionLink(``$pid = NULL, $extensionName = '', $pluginName = '', $controllerName = '', $actionName = '', $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get link to an action / controller

.. code-block:: php

	\nn\t3::Page()->getActionLink( $pid, $extName, $pluginName, $controllerName, $actionName, $args );

Example for the news extension:

.. code-block:: php

	$newsArticleUid = 45;
	$newsDetailPid = 123;
	\nn\t3::Page()->getActionLink( $newsDetailPid, 'news', 'pi1', 'News', 'detail', ['news'=>$newsArticleUid]);

| ``@return string``

| :ref:`➜ Go to source code of Page::getActionLink() <Page-getActionLink>`

\\nn\\t3::Page()->getChildPids(``$parentPid = 0, $recursive = 999``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of child ids of one or more pages.

.. code-block:: php

	\nn\t3::Page()->getChildPids( 123, 1 );
	\nn\t3::Page()->getChildPids( [123, 124], 99 );

| ``@return array``

| :ref:`➜ Go to source code of Page::getChildPids() <Page-getChildPids>`

\\nn\\t3::Page()->getData(``$pids = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get data of a page (table ``pages``).

.. code-block:: php

	// data of the current page
	\nn\t3::Page()->getData();
	
	// get data of the page with pid = 123
	\nn\t3::Page()->getData( 123 );
	
	// get data of the pages with pids = 123 and 456. Key of the array = pid
	\nn\t3::Page()->getData( [123, 456] );

| ``@return array``

| :ref:`➜ Go to source code of Page::getData() <Page-getData>`

\\nn\\t3::Page()->getField(``$key, $slide = false, $override = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get single field from page data.
The value can be inherited from parent pages via ``slide = true``.

(!) Important:
Custom fields must be defined as rootLine in ``ext_localconf.php``!
See also ``\nn\t3::Registry()->rootLineFields(['key', '...']);``

.. code-block:: php

	\nn\t3::Page()->getField('layout');
	\nn\t3::Page()->getField('backend_layout_next_level', true, 'backend_layout');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:page.data(key:'uid')}
	{nnt3:page.data(key:'media', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

| ``@return mixed``

| :ref:`➜ Go to source code of Page::getField() <Page-getField>`

\\nn\\t3::Page()->getLink(``$pidOrParams = NULL, $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate a simple link to a page in the frontend.

Works in any context - both from a backend module or scheduler/CLI job, as well as in the frontend context, e.g. in the controller or a ViewHelper.
Absolute URLs are generated from the backend context into the frontend. The URLs are encoded as readable URLs - the slug path or RealURL are taken into account.

.. code-block:: php

	\nn\t3::Page()->getLink( $pid );
	\nn\t3::Page()->getLink( $pid, $params );
	\nn\t3::Page()->getLink( $params );
	\nn\t3::Page()->getLink( $pid, true );
	\nn\t3::Page()->getLink( $pid, $params, true );
	\nn\t3::Page()->getLink( 'david@99grad.de' )

Example for generating a link to a controller:

Tip: see also ``\nn\t3::Page()->getActionLink()`` for a short version!

.. code-block:: php

	$newsDetailPid = 123;
	$newsArticleUid = 45;
	
	$link = \nn\t3::Page()->getLink($newsDetailPid, [
	    'tx_news_pi1' => [
	        'action' => 'detail',
	        'controller' => 'news',
	        'news' => $newsArticleUid,
	    ]
	]);

| ``@return string``

| :ref:`➜ Go to source code of Page::getLink() <Page-getLink>`

\\nn\\t3::Page()->getPageRenderer();
"""""""""""""""""""""""""""""""""""""""""""""""

Get page renderer

.. code-block:: php

	\nn\t3::Page()->getPageRenderer();

| ``@return PageRenderer``

| :ref:`➜ Go to source code of Page::getPageRenderer() <Page-getPageRenderer>`

\\nn\\t3::Page()->getPid(``$fallback = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get PID of the current page.
In the frontend: The current ``TSFE->id``
In the backend: The page that was selected in the page tree
Without context: The pid of the site root

.. code-block:: php

	\nn\t3::Page()->getPid();
	\nn\t3::Page()->getPid( $fallbackPid );

| ``@return int``

| :ref:`➜ Go to source code of Page::getPid() <Page-getPid>`

\\nn\\t3::Page()->getPidFromRequest();
"""""""""""""""""""""""""""""""""""""""""""""""

Get PID from request string, e.g. in backend modules.
Hacky. ToDo: Check if there is a better method.

.. code-block:: php

	\nn\t3::Page()->getPidFromRequest();

| ``@return int``

| :ref:`➜ Go to source code of Page::getPidFromRequest() <Page-getPidFromRequest>`

\\nn\\t3::Page()->getRootline(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get rootline for given PID

.. code-block:: php

	\nn\t3::Page()->getRootline();

| ``@return array``

| :ref:`➜ Go to source code of Page::getRootline() <Page-getRootline>`

\\nn\\t3::Page()->getSiteRoot(``$returnAll = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get PID of the site root(s).
Corresponds to the page in the backend that has the "globe" as an icon
(in the page properties "use as start of website")

.. code-block:: php

	\nn\t3::Page()->getSiteRoot();

| ``@return int``

| :ref:`➜ Go to source code of Page::getSiteRoot() <Page-getSiteRoot>`

\\nn\\t3::Page()->getSubpages(``$pid = NULL, $includeHidden = false, $includeAllTypes = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get menu for given PID

.. code-block:: php

	\nn\t3::Page()->getSubpages();
	\nn\t3::Page()->getSubpages( $pid );
	\nn\t3::Page()->getSubpages( $pid, true ); // Also get hidden pages
	\nn\t3::Page()->getSubpages( $pid, false, true ); // Get all page types
	\nn\t3::Page()->getSubpages( $pid, false, [PageRepository::DOKTYPE_SYSFOLDER] ); // Get specific page types

| ``@param int $pid``
| ``@param bool $includeHidden``
| ``@param bool|array $includeAllTypes``
| ``@return array``

| :ref:`➜ Go to source code of Page::getSubpages() <Page-getSubpages>`

\\nn\\t3::Page()->getTitle();
"""""""""""""""""""""""""""""""""""""""""""""""

Get current page title (without suffix)

.. code-block:: php

	\nn\t3::Page()->getTitle();

| ``@return string``

| :ref:`➜ Go to source code of Page::getTitle() <Page-getTitle>`

\\nn\\t3::Page()->hasSubpages(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether a page has submenus

.. code-block:: php

	\nn\t3::Page()->hasSubpages();

| ``@return boolean``

| :ref:`➜ Go to source code of Page::hasSubpages() <Page-hasSubpages>`

\\nn\\t3::Page()->setTitle(``$title = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change PageTitle (<title>-tag)
Does not work if EXT:advancedtitle is activated!

.. code-block:: php

	\nn\t3::Page()->setTitle('YEAH!');

Also available as ViewHelper:

.. code-block:: php

	{nnt3:page.title(title:'Yeah')}
	{entry.title->nnt3:page.title()}

| ``@return void``

| :ref:`➜ Go to source code of Page::setTitle() <Page-setTitle>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
