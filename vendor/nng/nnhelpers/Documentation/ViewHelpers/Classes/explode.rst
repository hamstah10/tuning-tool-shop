
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\ExplodeViewHelper:

=======================================
explode
=======================================

Description
---------------------------------------

<nnt3:explode />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

[Translate to EN] Macht aus einem String ein Array

.. code-block:: php

	{nnt3:explode(str:'1,2,3')}
	{mystring->nnt3:explode()}
	{mystring->nnt3:explode(delimiter:';')}
	{mystring->nnt3:explode(trim:0)}

| ``@return void``
