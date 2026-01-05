
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\IndentCodeViewHelper:

=======================================
format.indentCode
=======================================

Description
---------------------------------------

<nnt3:format.indentCode />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Fügt eine Einrückung (Indentation) zu jeder Zeile eines Code-Blocks hinzu.
Wird für die Sphinx-Dokumentation verwendet, um Code innerhalb von ``.. code-block::`` korrekt einzurücken.

.. code-block:: php

	{sourceCode->nnt3:format.indentCode(spaces: 3)}

| ``@return string``
