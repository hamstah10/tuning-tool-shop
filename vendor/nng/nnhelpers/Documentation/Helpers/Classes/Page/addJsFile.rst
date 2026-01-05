
.. include:: ../../../../Includes.txt

.. _Page-addJsFile:

==============================================
Page::addJsFile()
==============================================

\\nn\\t3::Page()->addJsFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
----------------------------------------------

JS file in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFile( 'path/to/file.js' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addJsFile($path, $compress = false, $atTop = false, $wrap = false, $concat = false ) {
   	$pageRenderer = $this->getPageRenderer();
   	$pageRenderer->addJsFile( $path, NULL, $compress, $atTop, $wrap, $concat );
   }
   

