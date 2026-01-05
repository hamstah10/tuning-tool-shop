
.. include:: ../../../../Includes.txt

.. _Page-addFooterData:

==============================================
Page::addFooterData()
==============================================

\\nn\\t3::Page()->addFooterData(``$html = ''``);
----------------------------------------------

HTML code before the end of the `` inject
See \nn\t3::Page()->addFooter() for simpler version.

.. code-block:: php

	\nn\t3::Page()->addFooterData( '' );

@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addFooterData( $html = '' ) {
   	$this->getPageRenderer()->addFooterData( $html );
   }
   

