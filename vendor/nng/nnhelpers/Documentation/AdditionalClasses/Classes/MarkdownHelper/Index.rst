
.. include:: ../../../Includes.txt

.. _MarkdownHelper:

==============================================
MarkdownHelper
==============================================

\\nn\\t3::MarkdownHelper()
----------------------------------------------

A wrapper for parsing markdown and translation into HTML and vice versa.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::MarkdownHelper()->parseComment(``$comment = '', $encode = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert comment string to readable HTML string
Comments can use Markdown.
Removes '' and '' etc.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::parseComment( '...' );

| ``@return string``

| :ref:`➜ Go to source code of MarkdownHelper::parseComment() <MarkdownHelper-parseComment>`

\\nn\\t3::MarkdownHelper()->removeAsterisks(``$comment = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes the comment asterisks in a text.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::removeAsterisks( '...' );

| ``@return string``

| :ref:`➜ Go to source code of MarkdownHelper::removeAsterisks() <MarkdownHelper-removeAsterisks>`

\\nn\\t3::MarkdownHelper()->toHTML(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a text containing markdown to HTML.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::toHTML( '...' );

| ``@return string``

| :ref:`➜ Go to source code of MarkdownHelper::toHTML() <MarkdownHelper-toHTML>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
