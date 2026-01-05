
.. include:: ../../../Includes.txt

.. _AnnotationHelper:

==============================================
AnnotationHelper
==============================================

\\nn\\t3::AnnotationHelper()
----------------------------------------------

Various methods for parsing PHP annotations

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::AnnotationHelper()->parse(``$rawAnnotation = '', $namespaces = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

parse annotations and return an array with the "normal" comment block and the individual
individual annotations from a DocComment.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...' );

Only fetch annotations that are in a specific namespace.
In this example, only annotations that begin with ``@nn\rest``
are fetched, e.g. ``@nn\rest\access ...``

.. code-block:: php

	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...', 'nn\rest' );
	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...', ['nn\rest', 'whatever'] );

| ``@return array``

| :ref:`➜ Go to source code of AnnotationHelper::parse() <AnnotationHelper-parse>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
