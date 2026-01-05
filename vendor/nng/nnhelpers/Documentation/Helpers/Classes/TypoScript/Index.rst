
.. include:: ../../../Includes.txt

.. _TypoScript:

==============================================
TypoScript
==============================================

\\nn\\t3::TypoScript()
----------------------------------------------

Methods for parsing and converting TypoScript

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TypoScript()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add page config
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	\nn\t3::TypoScript()->addPageConfig( '' );
	\nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

| :ref:`➜ Go to source code of TypoScript::addPageConfig() <TypoScript-addPageConfig>`

\\nn\\t3::TypoScript()->convertToPlainArray(``$ts``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert TypoScript 'name.' syntax to normal array.
Facilitates access

.. code-block:: php

	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);

| ``@return array``

| :ref:`➜ Go to source code of TypoScript::convertToPlainArray() <TypoScript-convertToPlainArray>`

\\nn\\t3::TypoScript()->fromString(``$str = '', $overrideSetup = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a text into a TypoScript array.

.. code-block:: php

	$example = '
	    lib.test {
	      someVal = 10
	    }
	';
	\nn\t3::TypoScript()->fromString($example); => ['lib'=>['test'=>['someVal'=>10]]]
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
