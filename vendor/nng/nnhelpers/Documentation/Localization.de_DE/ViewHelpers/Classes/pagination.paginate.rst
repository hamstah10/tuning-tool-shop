
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Pagination\PaginateViewHelper:

=======================================
pagination.paginate
=======================================

Description
---------------------------------------

<nnt3:pagination.paginate />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Ersatz für den ``f:widget.paginate`` ViewHelper, der in TYPO3 12 entfernt wurde.
DICKES DANKE an https://www.in2code.de/ für den Blog-Beitrag!

Partial für den Paginator in eigene Extension einbinden

.. code-block:: php

	plugin.tx_myext_plugin {
	partialRootPaths {
	 10 = EXT:nnhelpers/Resources/Private/Partials/
	}
	}

Im Fluid-Template:

.. code-block:: php

	<nnt3:pagination.paginate objects="{allItemsFromQuery}" as="items" paginator="paginator" itemsPerPage="{settings.numItemsPerPage}">
	<!-- Items render -->
	<f:for each="{items}" as="item">
	 ...
	</f:for>
	<!-- Pagination rendern aus nnhelpers -->
	<f:render partial="Pagination" arguments="{paginator:paginator}" />
	</nnt3>

| ``@return string``

