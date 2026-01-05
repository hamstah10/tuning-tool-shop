
.. include:: ../../../Includes.txt

.. _Tsfe:

==============================================
Tsfe
==============================================

\\nn\\t3::Tsfe()
----------------------------------------------

Everything about the Typo3 frontend.
Methods for initializing the FE from the backend context, access to the
cObj and cObjData etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Tsfe()->bootstrap(``$conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Bootstrap Typo3

.. code-block:: php

	\nn\t3::Tsfe()->bootstrap();
	\nn\t3::Tsfe()->bootstrap( ['vendorName'=>'Nng', 'extensionName'=>'Nnhelpers', 'pluginName'=>'Foo'] );

| :ref:`➜ Go to source code of Tsfe::bootstrap() <Tsfe-bootstrap>`

\\nn\\t3::Tsfe()->cObj(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get $GLOBALS['TSFE']->cObj.

.. code-block:: php

	// since TYPO3 12.4 within a controller:
	\nn\t3::Tsfe()->cObj( $this->request )

| ``@return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer``

| :ref:`➜ Go to source code of Tsfe::cObj() <Tsfe-cObj>`

\\nn\\t3::Tsfe()->cObjData(``$request = NULL, $var = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get $GLOBALS['TSFE']->cObj->data.

.. code-block:: php

	\nn\t3::Tsfe()->cObjData( $this->request ); => array with DB-row of the current content element
	\nn\t3::Tsfe()->cObjData( $this->request, 'uid' ); => uid of the current content element

| ``@return mixed``

| :ref:`➜ Go to source code of Tsfe::cObjData() <Tsfe-cObjData>`

\\nn\\t3::Tsfe()->cObjGetSingle(``$type = '', $conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Render a TypoScript object.
Earlier: ``$GLOBALS['TSFE']->cObj->cObjGetSingle()``

.. code-block:: php

	\nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'image.jpg', 'file.'=>['maxWidth'=>200]] )

| :ref:`➜ Go to source code of Tsfe::cObjGetSingle() <Tsfe-cObjGetSingle>`

\\nn\\t3::Tsfe()->forceAbsoluteUrls(``$enable = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets ``config.absRefPrefix`` to the current URL.

This means that when rendering the links of content elements
absolute URLs are used. Does not (yet) work for images.

.. code-block:: php

	\nn\t3::Environment()->forceAbsoluteUrls();
	$html = \nn\t3::Content()->render(123);

| :ref:`➜ Go to source code of Tsfe::forceAbsoluteUrls() <Tsfe-forceAbsoluteUrls>`

\\nn\\t3::Tsfe()->get(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get $GLOBALS['TSFE'].
If not available (because in BE) initialize.

.. code-block:: php

	\nn\t3::Tsfe()->get()
	\nn\t3::Tsfe()->get()

| ``@return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController``

| :ref:`➜ Go to source code of Tsfe::get() <Tsfe-get>`

\\nn\\t3::Tsfe()->includeHiddenRecords(``$includeHidden = false, $includeStartEnd = false, $includeDeleted = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get hidden content elements in the frontend.
Can be used before rendering.

.. code-block:: php

	\nn\t3::Tsfe()->includeHiddenRecords(true, true, true);
	$html = \nn\t3::Content()->render(123);

| ``@param bool $includeHidden``
| ``@param bool $includeStartEnd``
| ``@param bool $includeDeleted``
| ``@return void``

| :ref:`➜ Go to source code of Tsfe::includeHiddenRecords() <Tsfe-includeHiddenRecords>`

\\nn\\t3::Tsfe()->init(``$pid = 0, $typeNum = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Initialize the ``$GLOBALS['TSFE']``
Only used for compatibility with older code that still uses ``$GLOBALS['TSFE']``.

.. code-block:: php

	// Get TypoScript the 'old' way
	$pid = \nn\t3::Page()->getPid();
	\nn\t3::Tsfe()->init($pid);
	$setup = $GLOBALS['TSFE']->tmpl->setup;

| ``@param int $pid``
| ``@param int $typeNum``
| ``@return void``

| :ref:`➜ Go to source code of Tsfe::init() <Tsfe-init>`

\\nn\\t3::Tsfe()->injectTypoScript(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inject fully initialized TypoScript into the request.

This is necessary when executing in a cached frontend context
in which the TypoScript setup array is not initialized. It uses the
TypoScriptHelper to create a complete TypoScript object and place it
into the ``frontend.typoscript attribute`` of the request.

.. code-block:: php

	// In the middleware:
	$request = \nn\t3::Tsfe()->injectTypoScript( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest $request``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Tsfe::injectTypoScript() <Tsfe-injectTypoScript>`

\\nn\\t3::Tsfe()->softDisableCache(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deactivate cache for the frontend.

"Soft" variant: Uses a fake USER_INT object so that already rendered elements
elements do not have to be rendered again. Workaround for TYPO3 v12+, since
TypoScript Setup & Constants are no longer initialized when page is
completely loaded from the cache.

.. code-block:: php

	\nn\t3::Tsfe()->softDisableCache()

| ``@param \TYPO3\CMS\Core\Http\ServerRequest $request``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Tsfe::softDisableCache() <Tsfe-softDisableCache>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
