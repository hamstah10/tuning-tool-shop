
.. include:: ../../../../Includes.txt

.. _Template-setTemplatePaths:

==============================================
Template::setTemplatePaths()
==============================================

\\nn\\t3::Template()->setTemplatePaths(``$view = NULL, $defaultTemplatePaths = [], $additionalTemplatePaths = []``);
----------------------------------------------

Setzt Templates, Partials und Layouts für einen View.
$additionalTemplatePaths kann übergeben werden, um Pfade zu priorisieren

.. code-block:: php

	\nn\t3::Template()->setTemplatePaths( $this->view, $templatePaths );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setTemplatePaths ( $view = null, $defaultTemplatePaths = [], $additionalTemplatePaths = []) {
   	$mergedPaths = $this->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );
   	if ($paths = $mergedPaths['templateRootPaths'] ?? false) {
   		$view->setTemplateRootPaths($paths);
   	}
   	if ($paths = $mergedPaths['partialRootPaths'] ?? false) {
   		$view->setPartialRootPaths($paths);
   	}
   	if ($paths = $mergedPaths['layoutRootPaths'] ?? false) {
   		$view->setLayoutRootPaths($paths);
   	}
      	if ($path = $mergedPaths['template'] ?? false) {
   		$view->setTemplate($path);
   	}
   	return $mergedPaths;
   }
   

