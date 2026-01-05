
.. include:: ../../../../Includes.txt

.. _Settings-addPageConfig:

==============================================
Settings::addPageConfig()
==============================================

\\nn\\t3::Settings()->addPageConfig(``$str = ''``);
----------------------------------------------

Add page config
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::Settings()->addPageConfig( 'test.was = 10' );
	\nn\t3::Settings()->addPageConfig( '' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addPageConfig( $str = '' )
   {
   	\nn\t3::Registry()->addPageConfig( $str );
   }
   

