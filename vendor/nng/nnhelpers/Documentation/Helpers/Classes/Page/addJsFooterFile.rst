
.. include:: ../../../../Includes.txt

.. _Page-addJsFooterFile:

==============================================
Page::addJsFooterFile()
==============================================

\\nn\\t3::Page()->addJsFooterFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

JS file at the end of the `` inject
See \nn\t3::Page()->addJsFooterFile() for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFooterFile( 'path/to/file.js' );

@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addJsFooterFile($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$this->getPageRenderer()->addJsFooterFile( $path, NULL, $compress, $atTop, $wrap, $concat );
   }
   

