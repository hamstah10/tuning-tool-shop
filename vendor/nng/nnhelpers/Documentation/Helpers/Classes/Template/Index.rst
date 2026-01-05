
.. include:: ../../../Includes.txt

.. _Template:

==============================================
Template
==============================================

\\nn\\t3::Template()
----------------------------------------------

Render fluid templates and manipulate paths to templates in the view.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Template()->findTemplate(``$view = NULL, $templateName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds a template in an array of possible templatePaths of the view

.. code-block:: php

	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );

| ``@return string``

| :ref:`➜ Go to source code of Template::findTemplate() <Template-findTemplate>`

\\nn\\t3::Template()->getVariable(``$view, $varname = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fetches ONE variable of the current view, i.e:
Everything that was set via assign() and assignMultiple().

In the ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariable( $renderingContext, 'varname' );

In the controller:

.. code-block:: php

	\nn\t3::Template()->getVariable( $this->view, 'varname' );

| ``@return array``

| :ref:`➜ Go to source code of Template::getVariable() <Template-getVariable>`

\\nn\\t3::Template()->getVariables(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves the variables of the current view, i.e:
Everything that was set via assign() and assignMultiple().

In the ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

In the controller:

.. code-block:: php

	\nn\t3::Template()->getVariables( $this->view );

| ``@return array``

| :ref:`➜ Go to source code of Template::getVariables() <Template-getVariables>`

\\nn\\t3::Template()->mergeTemplatePaths(``$defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge paths to templates, partials, layout

.. code-block:: php

	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

| ``@return array``

| :ref:`➜ Go to source code of Template::mergeTemplatePaths() <Template-mergeTemplatePaths>`

\\nn\\t3::Template()->removeControllerPath(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes the path of the controller name, e.g. /Main/...
from the search for templates.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

| :ref:`➜ Go to source code of Template::removeControllerPath() <Template-removeControllerPath>`

\\nn\\t3::Template()->render(``$templateName = NULL, $vars = [], $templatePaths = [], $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Template::render() <Template-render>`

\\nn\\t3::Template()->renderHtml(``$html = NULL, $vars = [], $templatePaths = [], $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Render simple fluid code via standalone renderer

.. code-block:: php

	    \nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	    \nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	    \nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );

Since TYPO3 12, the ``$request`` must also be passed when calling from a controller:

.. code-block:: php

	\nn\t3::Template()->renderHtml( 'templatename', $vars, $templatePaths, $this->request );

| ``@return string``

| :ref:`➜ Go to source code of Template::renderHtml() <Template-renderHtml>`

\\nn\\t3::Template()->setTemplatePaths(``$view = NULL, $defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets templates, partials and layouts for a view.
$additionalTemplatePaths can be passed to prioritize paths

.. code-block:: php

	\nn\t3::Template()->setTemplatePaths( $this->view, $templatePaths );

| ``@return array``

| :ref:`➜ Go to source code of Template::setTemplatePaths() <Template-setTemplatePaths>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
