
.. include:: ../../../../Includes.txt

.. _Page-addJsFooterLibrary:

==============================================
Page::addJsFooterLibrary()
==============================================

\\nn\\t3::Page()->addJsFooterLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

JS library at the end of the `` inject

.. code-block:: php

	\nn\t3::Page()->addJsFooterLibrary( 'path/to/file.js' );

@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addJsFooterLibrary($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$this->getPageRenderer()->addJsFooterLibrary( $path, $path, NULL, $compress, $atTop, $wrap, $concat );
   }
   

