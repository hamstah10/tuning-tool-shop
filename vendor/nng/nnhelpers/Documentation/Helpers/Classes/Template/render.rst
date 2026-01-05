
.. include:: ../../../../Includes.txt

.. _Template-render:

==============================================
Template::render()
==============================================

\\nn\\t3::Template()->render(``$templateName = NULL, $vars = [], $templatePaths = [], $request = NULL``);
----------------------------------------------

Render a Fluid template using the standalone renderer

.. code-block:: php

	\nn\t3::Template()->render( 'Templatename', $vars, $templatePaths );
	\nn\t3::Template()->render( 'Templatename', $vars, 'myext' );
	\nn\t3::Template()->render( 'Templatename', $vars, 'tx_myext_myplugin' );
	\nn\t3::Template()->render( 'fileadmin/Fluid/Demo.html', $vars );

Since TYPO3 12, the ``$request`` must also be passed when calling from a controller:

.. code-block:: php

	\nn\t3::Template()->render( 'templatename', $vars, $templatePaths, $this->request );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function render ( $templateName = null, $vars = [], $templatePaths = [], $request = null )
   {
   	$view = \nn\t3::injectClass(StandaloneView::class);
   	if (!$request) {
   		$request = \nn\t3::Environment()->getRequest();
   	}
   	if ($request) {
   		$view->setRequest( $request );
   	}
   	if ($templatePaths) {
   		// String wurde als TemplatePath übergeben
   		if (is_string($templatePaths)) {
   			if ($paths = \nn\t3::Settings()->getPlugin($templatePaths)) {
   				$templatePaths = $paths['view'];
   			}
   		}
   		if ($templateName) {
   			$templatePaths['template'] = $templateName;
   		}
   		$this->setTemplatePaths( $view, $templatePaths );
   		$this->removeControllerPath( $view );
   	} else {
   		$view->setTemplatePathAndFilename( $templateName );
   	}
   	$view->assignMultiple( $vars );
   	return $view->render();
   }
   

