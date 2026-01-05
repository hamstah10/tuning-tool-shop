
.. include:: ../../../../Includes.txt

.. _Page-addFooterData:

==============================================
Page::addFooterData()
==============================================

\\nn\\t3::Page()->addFooterData(``$html = ''``);
----------------------------------------------

HTML-Code vor Ende der ``<body>`` einschleusen
Siehe ``\nn\t3::Page()->addFooter()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addFooterData( '<script src="..."></script>' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addFooterData( $html = '' ) {
   	$this->getPageRenderer()->addFooterData( $html );
   }
   

