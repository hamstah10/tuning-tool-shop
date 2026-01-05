
.. include:: ../../../../Includes.txt

.. _Page-addJsLibrary:

==============================================
Page::addJsLibrary()
==============================================

\\nn\\t3::Page()->addJsLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

JS library in ```` inject.

.. code-block:: php

	\nn\t3::Page()->addJsLibrary( 'path/to/file.js' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addJsLibrary($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$pageRenderer = $this->getPageRenderer();
   	$pageRenderer->addJsLibrary( $path, $path, NULL, $compress, $atTop, $wrap, $concat );
   }
   

