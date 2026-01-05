
.. include:: ../../../Includes.txt

.. _Template:

==============================================
Template
==============================================

\\nn\\t3::Template()
----------------------------------------------

Fluid Templates rendern und Pfade zu Templates im View manipulieren.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Template()->findTemplate(``$view = NULL, $templateName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet ein Template in einem Array von möglichen templatePaths des Views

.. code-block:: php

	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );

| ``@return string``

| :ref:`➜ Go to source code of Template::findTemplate() <Template-findTemplate>`

\\nn\\t3::Template()->getVariable(``$view, $varname = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt EINE Variables des aktuellen Views, sprich:
Alles, was per assign() und assignMultiple() gesetzt wurde.

Im ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariable( $renderingContext, 'varname' );

Im Controller:

.. code-block:: php

	\nn\t3::Template()->getVariable( $this->view, 'varname' );

| ``@return array``

| :ref:`➜ Go to source code of Template::getVariable() <Template-getVariable>`

\\nn\\t3::Template()->getVariables(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt die Variables des aktuellen Views, sprich:
Alles, was per assign() und assignMultiple() gesetzt wurde.

Im ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

Im Controller:

.. code-block:: php

	\nn\t3::Template()->getVariables( $this->view );

| ``@return array``

| :ref:`➜ Go to source code of Template::getVariables() <Template-getVariables>`

\\nn\\t3::Template()->mergeTemplatePaths(``$defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Pfade zu Templates, Partials, Layout mergen

.. code-block:: php

	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

| ``@return array``

| :ref:`➜ Go to source code of Template::mergeTemplatePaths() <Template-mergeTemplatePaths>`

\\nn\\t3::Template()->removeControllerPath(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt den Pfad des Controller-Names z.B. /Main/...
aus der Suche nach Templates.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

| :ref:`➜ Go to source code of Template::removeControllerPath() <Template-removeControllerPath>`

\\nn\\t3::Template()->render(``$templateName = NULL, $vars = [], $templatePaths = [], $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Fluid-Templates rendern per StandAlone-Renderer

.. code-block:: php

	\nn\t3::Template()->render( 'Templatename', $vars, $templatePaths );
	\nn\t3::Template()->render( 'Templatename', $vars, 'myext' );
	\nn\t3::Template()->render( 'Templatename', $vars, 'tx_myext_myplugin' );
	\nn\t3::Template()->render( 'fileadmin/Fluid/Demo.html', $vars );

Seit TYPO3 12 muss beim Aufruf aus einem Controller auch der ``$request`` übergeben werden:

.. code-block:: php

	\nn\t3::Template()->render( 'Templatename', $vars, $templatePaths, $this->request );

| ``@return string``

| :ref:`➜ Go to source code of Template::render() <Template-render>`

\\nn\\t3::Template()->renderHtml(``$html = NULL, $vars = [], $templatePaths = [], $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

einfachen Fluid-Code rendern per StandAlone-Renderer

.. code-block:: php

	    \nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	    \nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	    \nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );

Seit TYPO3 12 muss beim Aufruf aus einem Controller auch der ``$request`` übergeben werden:

.. code-block:: php

	\nn\t3::Template()->renderHtml( 'Templatename', $vars, $templatePaths, $this->request );

| ``@return string``

| :ref:`➜ Go to source code of Template::renderHtml() <Template-renderHtml>`

\\nn\\t3::Template()->setTemplatePaths(``$view = NULL, $defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt Templates, Partials und Layouts für einen View.
$additionalTemplatePaths kann übergeben werden, um Pfade zu priorisieren

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
