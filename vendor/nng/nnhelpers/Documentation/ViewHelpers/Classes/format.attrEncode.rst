
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\AttrEncodeViewHelper:

=======================================
format.attrEncode
=======================================

Description
---------------------------------------

<nnt3:format.attrEncode />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

[Translate to EN] Maskiert "kritische" Zeichen, damit sie als Attribut an einen HTML-Tag verwendet werden können.

.. code-block:: php

	<div data-example="{something->nnt3:format.attrEncode()}"> ... </div>
	<a title="{title->nnt3:format.attrEncode()}"> ... </a>

| ``@return string``
