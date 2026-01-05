
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Parse\CodeViewHelper:

=======================================
parse.code
=======================================

Description
---------------------------------------

<nnt3:parse.code />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Ensures HTML entities inside ``<code>`` blocks are properly encoded.

This is useful when displaying code examples that may contain HTML tags
which should be shown as readable code, not rendered as HTML.

.. code-block:: php

	{item.comment->nnt3:parse.code()->f:format.raw()}

| ``@return string``
