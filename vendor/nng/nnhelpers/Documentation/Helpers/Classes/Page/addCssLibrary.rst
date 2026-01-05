
.. include:: ../../../../Includes.txt

.. _Page-addCssLibrary:

==============================================
Page::addCssLibrary()
==============================================

\\nn\\t3::Page()->addCssLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

CSS library in ```` inject

.. code-block:: php

	\nn\t3::Page()->addCssLibrary( 'path/to/style.css' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addCssLibrary($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$this->getPageRenderer()->addCssLibrary( $path, 'stylesheet', 'all', '', $compress, $atTop, $wrap, $concat );
   }
   

