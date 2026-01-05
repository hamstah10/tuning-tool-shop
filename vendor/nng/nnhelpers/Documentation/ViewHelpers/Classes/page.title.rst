
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Page\TitleViewHelper:

=======================================
page.title
=======================================

Description
---------------------------------------

<nnt3:page.title />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

[Translate to EN] Aktuelle Page-Title setzen.

Andert das ``<title>``-Tag der aktuellen Seite.

Funktioniert nicht, wenn ``EXT:advancedtitle`` aktiviert ist!

.. code-block:: php

	{nnt3:page.title(title:'Seitentitel')}
	{entry.title->nnt3:page.title()}

