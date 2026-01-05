
.. include:: ../../../../Includes.txt

.. _Template-findTemplate:

==============================================
Template::findTemplate()
==============================================

\\nn\\t3::Template()->findTemplate(``$view = NULL, $templateName = ''``);
----------------------------------------------

Findet ein Template in einem Array von möglichen templatePaths des Views

.. code-block:: php

	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function findTemplate( $view = null, $templateName = '' ) {
   	$paths = array_reverse($view->getTemplateRootPaths());
   	$templateName = pathinfo( $templateName, PATHINFO_FILENAME );
   	foreach ($paths as $path) {
   		if (\nn\t3::File()->exists( $path . $templateName . '.html')) {
   			return $path . $templateName . '.html';
   		}
   		if (\nn\t3::File()->exists( $path . $templateName)) {
   			return $path . $templateName;
   		}
   	}
   	return false;
   }
   

