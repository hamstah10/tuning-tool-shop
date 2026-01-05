
.. include:: ../../../../Includes.txt

.. _Page-addHeaderData:

==============================================
Page::addHeaderData()
==============================================

\\nn\\t3::Page()->addHeaderData(``$html = ''``);
----------------------------------------------

HTML code in ```` inject
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addHeaderData( '' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addHeaderData( $html = '' ) {
   	$this->getPageRenderer()->addHeaderData( $html );
   }
   

