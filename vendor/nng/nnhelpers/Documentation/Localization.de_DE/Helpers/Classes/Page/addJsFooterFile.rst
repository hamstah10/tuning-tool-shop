
.. include:: ../../../../Includes.txt

.. _Page-addJsFooterFile:

==============================================
Page::addJsFooterFile()
==============================================

\\nn\\t3::Page()->addJsFooterFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

JS-Datei am Ende der ``<body>`` einschleusen
Siehe ``\nn\t3::Page()->addJsFooterFile()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addJsFooterFile( 'path/to/file.js' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addJsFooterFile($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$this->getPageRenderer()->addJsFooterFile( $path, NULL, $compress, $atTop, $wrap, $concat );
   }
   

