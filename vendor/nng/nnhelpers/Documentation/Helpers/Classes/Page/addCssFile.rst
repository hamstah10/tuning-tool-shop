
.. include:: ../../../../Includes.txt

.. _Page-addCssFile:

==============================================
Page::addCssFile()
==============================================

\\nn\\t3::Page()->addCssFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

CSS file in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addCss( 'path/to/style.css' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addCssFile($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$this->getPageRenderer()->addCssFile( $path, 'stylesheet', 'all', '', $compress, $atTop, $wrap, $concat );
   }
   

