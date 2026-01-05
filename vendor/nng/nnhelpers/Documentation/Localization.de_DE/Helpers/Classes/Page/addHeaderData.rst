
.. include:: ../../../../Includes.txt

.. _Page-addHeaderData:

==============================================
Page::addHeaderData()
==============================================

\\nn\\t3::Page()->addHeaderData(``$html = ''``);
----------------------------------------------

HTML-Code in ``<head>`` einschleusen
Siehe ``\nn\t3::Page()->addHeader()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addHeaderData( '<script src="..."></script>' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addHeaderData( $html = '' ) {
   	$this->getPageRenderer()->addHeaderData( $html );
   }
   

