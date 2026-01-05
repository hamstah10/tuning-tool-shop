
.. include:: ../../../../Includes.txt

.. _Page-addHeader:

==============================================
Page::addHeader()
==============================================

\\nn\\t3::Page()->addHeader(``$str = ''``);
----------------------------------------------

CSS oder JS oder HTML-Code an Footer anhängen.
Entscheidet selbst, welche Methode des PageRenderes zu verwenden ist.

.. code-block:: php

	\nn\t3::Page()->addHeader( 'fileadmin/style.css' );
	\nn\t3::Page()->addHeader( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addHeader( 'js/script.js' );
	\nn\t3::Page()->addHeader( '<script>....</script>' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addHeader ( $str = '' ) {
   	if (!is_array($str)) $str = [$str];
   	foreach ($str as $n) {
   		if (strpos($n, '<') !== false) {
   			$this->addHeaderData( $n );
   		} else {
   			$suffix = \nn\t3::File()->suffix($n);
   			if ($suffix == 'js') {
   				$this->addJsFile( $n );
   			} else {
   				// addCssFooterFile() scheint nicht zu existieren
   				$this->addCssLibrary( $n );
   			}
   		}
   	}
   }
   

