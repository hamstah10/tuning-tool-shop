
.. include:: ../../../../Includes.txt

.. _Page-addFooter:

==============================================
Page::addFooter()
==============================================

\\nn\\t3::Page()->addFooter(``$str = ''``);
----------------------------------------------

Append CSS or JS or HTML code to the footer.
Decide for yourself which PageRender method to use.

.. code-block:: php

	\nn\t3::Page()->addFooter( 'fileadmin/style.css' );
	\nn\t3::Page()->addFooter( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addFooter( 'js/script.js' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addFooter ( $str = '' ) {
   	if (!is_array($str)) $str = [$str];
   	foreach ($str as $n) {
   		if (strpos($n, '<') !== false) {
   			$this->addFooterData( $n );
   		} else {
   			$suffix = \nn\t3::File()->suffix($n);
   			if ($suffix == 'js') {
   				$this->addJsFooterFile( $n );
   			} else {
   				// addCssFooterFile() scheint nicht zu existieren
   				$this->addCssLibrary( $n );
   			}
   		}
   	}
   }
   

