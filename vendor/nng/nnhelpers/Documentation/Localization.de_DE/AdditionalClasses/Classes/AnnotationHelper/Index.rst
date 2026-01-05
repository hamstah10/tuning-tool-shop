
.. include:: ../../../Includes.txt

.. _AnnotationHelper:

==============================================
AnnotationHelper
==============================================

\\nn\\t3::AnnotationHelper()
----------------------------------------------

Diverse Methoden zum Parsen von PHP-Annotations

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::AnnotationHelper()->parse(``$rawAnnotation = '', $namespaces = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Annotations parsen und ein Array mit dem "normalen" Kommentarblock und den
einzelnen Annotations aus einem DocComment zurückgeben.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...' );

Nur Annotations holen, die in einem bestimmten Namespace sind.
In diesem Beispiel werden nur Annotations geholt, die mit ``@nn\rest``
beginnen, z.B. ``@nn\rest\access ...``

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
