
.. include:: ../../../Includes.txt

.. _DocumentationHelper:

==============================================
DocumentationHelper
==============================================

\\nn\\t3::DocumentationHelper()
----------------------------------------------

Various methods for parsing PHP source code and comments in the source code
source code (annotations). Objective: To create automated documentation from the comments
in the PHP code.

Examples for the use incl. rendering of the template

In the controller with rendering via Fluid:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	$this->view->assign('doc', $doc);

Generate the Typo3 / Sphinx ReST document via a custom Fluid template:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	
	foreach ($doc as $className=>$infos) {
	  $rendering = \nn\t3::Template()->render(
	    'EXT:myext/Resources/Private/Backend/Templates/Documentation/ClassTemplate.html', [
	      'infos' => $infos
	    ]
	  );
	
	  $filename = $infos['fileName'] . '.rst';
	  $file = \nn\t3::File()->absPath('EXT:myext/Documentation/Utilities/Classes/' . $filename);
	  $result = file_put_contents( $file, $rendering );
	}

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::DocumentationHelper()->getClassNameFromFile(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get class name as string incl. full namespace from a PHP file.
For example, returns ``Nng\Classes\MyClass``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::getClassNameFromFile( 'Classes/MyClass.php' );

| ``@return string``

| :ref:`➜ Go to source code of DocumentationHelper::getClassNameFromFile() <DocumentationHelper-getClassNameFromFile>`

\\nn\\t3::DocumentationHelper()->getSourceCode(``$class, $method``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get source code of a method.

Returns the "raw" PHP code of the method of a class.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class, 'myMethodName' );

| ``@return string``

| :ref:`➜ Go to source code of DocumentationHelper::getSourceCode() <DocumentationHelper-getSourceCode>`

\\nn\\t3::DocumentationHelper()->parseClass(``$className = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get information about a specific class.

Similar to ``parseFile()`` - however, the actual class name must be passed here.
If you only know the path to the PHP file, use ``parseFile()``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class );

| ``@return array``

| :ref:`➜ Go to source code of DocumentationHelper::parseClass() <DocumentationHelper-parseClass>`

\\nn\\t3::DocumentationHelper()->parseFile(``$path = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all information about a single PHP file.

Parses the annotation above the class definition and optionally also all methods of the class.
Returns an array where the arguments / parameters of each method are also listed.

Markdown can be used in the annotations, the Markdown is automatically converted to HTML code.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFile( 'Path/Classes/MyClass.php' );

| ``@return array``

| :ref:`➜ Go to source code of DocumentationHelper::parseFile() <DocumentationHelper-parseFile>`

\\nn\\t3::DocumentationHelper()->parseFolder(``$path = '', $options = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse a folder (recursively) for classes with annotations.
Returns an array with information about each class and its methods.

The annotations (comments) above the class methods can be formatted in Markdown, they are automatically converted to HTML with appropriate <code><pre></code> and <code><code></code> tags are converted.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/To/Classes/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'EXT:myext/Classes/ViewHelpers/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/Somewhere/', ['recursive'=>false, 'suffix'=>'php', 'parseMethods'=>false] );

| ``@return array``

| :ref:`➜ Go to source code of DocumentationHelper::parseFolder() <DocumentationHelper-parseFolder>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
