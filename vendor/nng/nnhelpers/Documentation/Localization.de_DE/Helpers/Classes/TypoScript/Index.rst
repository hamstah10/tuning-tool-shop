
.. include:: ../../../Includes.txt

.. _TypoScript:

==============================================
TypoScript
==============================================

\\nn\\t3::TypoScript()
----------------------------------------------

Methoden zum Parsen und Konvertieren von TypoScript

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TypoScript()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Config hinzufügen
Alias zu ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	\nn\t3::TypoScript()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

| :ref:`➜ Go to source code of TypoScript::addPageConfig() <TypoScript-addPageConfig>`

\\nn\\t3::TypoScript()->convertToPlainArray(``$ts``);
"""""""""""""""""""""""""""""""""""""""""""""""

TypoScript 'name.'-Syntax in normales Array umwandeln.
Erleichtert den Zugriff

.. code-block:: php

	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);

| ``@return array``

| :ref:`➜ Go to source code of TypoScript::convertToPlainArray() <TypoScript-convertToPlainArray>`

\\nn\\t3::TypoScript()->fromString(``$str = '', $overrideSetup = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt einen Text in ein TypoScript-Array um.

.. code-block:: php

	$example = '
	    lib.test {
	      someVal = 10
	    }
	';
	\nn\t3::TypoScript()->fromString($example);  => ['lib'=>['test'=>['someVal'=>10]]]
	\nn\t3::TypoScript()->fromString($example, $mergeSetup); => ['lib'=>['test'=>['someVal'=>10]]]

| ``@return array``

| :ref:`➜ Go to source code of TypoScript::fromString() <TypoScript-fromString>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
