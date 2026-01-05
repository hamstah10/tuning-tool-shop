
.. include:: ../../../Includes.txt

.. _Tsfe:

==============================================
Tsfe
==============================================

\\nn\\t3::Tsfe()
----------------------------------------------

Alles rund um das Typo3 Frontend.
Methoden zum Initialisieren des FE aus dem Backend-Context, Zugriff auf das
cObj und cObjData etc.

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

$GLOBALS['TSFE']->cObj holen.

.. code-block:: php

	// seit TYPO3 12.4 innerhalb eines Controllers:
	\nn\t3::Tsfe()->cObj( $this->request  )

| ``@return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer``

| :ref:`➜ Go to source code of Tsfe::cObj() <Tsfe-cObj>`

\\nn\\t3::Tsfe()->cObjData(``$request = NULL, $var = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

$GLOBALS['TSFE']->cObj->data holen.

.. code-block:: php

	\nn\t3::Tsfe()->cObjData( $this->request ); => array mit DB-row des aktuellen Content-Elementes
	\nn\t3::Tsfe()->cObjData( $this->request, 'uid' );  => uid des aktuellen Content-Elements

| ``@return mixed``

| :ref:`➜ Go to source code of Tsfe::cObjData() <Tsfe-cObjData>`

\\nn\\t3::Tsfe()->cObjGetSingle(``$type = '', $conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein TypoScript-Object rendern.
Früher: ``$GLOBALS['TSFE']->cObj->cObjGetSingle()``

.. code-block:: php

	\nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'bild.jpg', 'file.'=>['maxWidth'=>200]] )

| :ref:`➜ Go to source code of Tsfe::cObjGetSingle() <Tsfe-cObjGetSingle>`

\\nn\\t3::Tsfe()->forceAbsoluteUrls(``$enable = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt ``config.absRefPrefix`` auf die aktuelle URL.

Damit werden beim Rendern der Links von Content-Elementen
absolute URLs verwendet. Funktioniert zur Zeit (noch) nicht für Bilder.

.. code-block:: php

	\nn\t3::Environment()->forceAbsoluteUrls();
	$html = \nn\t3::Content()->render(123);

| :ref:`➜ Go to source code of Tsfe::forceAbsoluteUrls() <Tsfe-forceAbsoluteUrls>`

\\nn\\t3::Tsfe()->get(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

$GLOBALS['TSFE'] holen.
Falls nicht vorhanden (weil im BE) initialisieren.

.. code-block:: php

	\nn\t3::Tsfe()->get()
	\nn\t3::Tsfe()->get()

| ``@return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController``

| :ref:`➜ Go to source code of Tsfe::get() <Tsfe-get>`

\\nn\\t3::Tsfe()->includeHiddenRecords(``$includeHidden = false, $includeStartEnd = false, $includeDeleted = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ausgeblendete (hidden) Inhaltselemente im Frontend holen.
Kann vor dem Rendern verwendet werden.

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

Das ``$GLOBALS['TSFE']`` initialisieren.
Dient nur zur Kompatibilität mit älterem Code, das noch ``$GLOBALS['TSFE']`` verwendet.

.. code-block:: php

	// TypoScript holen auf die 'alte' Art
	$pid = \nn\t3::Page()->getPid();
	\nn\t3::Tsfe()->init($pid);
	$setup = $GLOBALS['TSFE']->tmpl->setup;

| ``@param int $pid``
| ``@param int $typeNum``
| ``@return void``

| :ref:`➜ Go to source code of Tsfe::init() <Tsfe-init>`

\\nn\\t3::Tsfe()->injectTypoScript(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Vollständig initialisiertes TypoScript in den Request einschleusen.

Dies ist erforderlich, wenn in einem gecachten Frontend-Kontext ausgeführt wird,
in dem das TypoScript-Setup-Array nicht initialisiert ist. Es verwendet den
TypoScriptHelper, um ein vollständiges TypoScript-Objekt zu erstellen und es
in das ``frontend.typoscript``-Attribut des Requests einzuschleusen.

.. code-block:: php

	// In der Middleware:
	$request = \nn\t3::Tsfe()->injectTypoScript( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest $request``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Tsfe::injectTypoScript() <Tsfe-injectTypoScript>`

\\nn\\t3::Tsfe()->softDisableCache(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Cache für das Frontend deaktivieren.

"Softe" Variante: Nutzt ein fake USER_INT-Objekt, damit bereits gerenderte
Elemente nicht neu gerendert werden müssen. Workaround für TYPO3 v12+, da
TypoScript Setup & Constants nicht mehr initialisiert werden, wenn Seite
vollständig aus dem Cache geladen werden.

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
