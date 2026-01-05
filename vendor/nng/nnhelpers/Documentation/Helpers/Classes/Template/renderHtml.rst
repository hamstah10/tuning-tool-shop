
.. include:: ../../../../Includes.txt

.. _Template-renderHtml:

==============================================
Template::renderHtml()
==============================================

\\nn\\t3::Template()->renderHtml(``$html = NULL, $vars = [], $templatePaths = [], $request = NULL``);
----------------------------------------------

Render simple fluid code via standalone renderer

.. code-block:: php

	    \nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	    \nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	    \nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );

Since TYPO3 12, the ``$request`` must also be passed when calling from a controller:

.. code-block:: php

	\nn\t3::Template()->renderHtml( 'templatename', $vars, $templatePaths, $this->request );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function renderHtml ( $html = null, $vars = [], $templatePaths = [], $request = null) {
   	$returnArray = is_array($html);
   	if (!$returnArray) $html = [$html];
   	$view = \nn\t3::injectClass(StandaloneView::class);
   	// @todo: Prüfen, of das geht?
   	if (!$request) {
   		//$request = $GLOBALS['TYPO3_REQUEST'] ?? false;
   	}
   	if ($request) {
   		$view->setRequest( $request);
   	}
   	if ($templatePaths) {
   		$this->setTemplatePaths( $view, $templatePaths );
   		$this->removeControllerPath( $view );
   	}
   	if (is_array($vars)) {
   		$view->assignMultiple( $vars );
   	}
   	foreach ($html as $k=>$v) {
   		if (is_string($v) && trim($v)) {
   			// ersetzt maskierte Viewhelper wie `{test-&gt;f:debug()}` mit `{test->f:debug()}`
   			$v = preg_replace('/{([^}]*)(-&gt;|→)([^}]*)}/', '{$1->$3}', $v);
   			$view->setTemplateSource( $v );
   			$html[$k] = $view->render();
   		} else {
   			$html[$k] = $v;
   		}
   	}
   	return $returnArray ? $html : $html[0];
   }
   

