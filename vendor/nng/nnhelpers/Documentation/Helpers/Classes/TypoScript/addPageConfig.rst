
.. include:: ../../../../Includes.txt

.. _TypoScript-addPageConfig:

==============================================
TypoScript::addPageConfig()
==============================================

\\nn\\t3::TypoScript()->addPageConfig(``$str = ''``);
----------------------------------------------

Add page config
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	\nn\t3::TypoScript()->addPageConfig( '' );
	\nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addPageConfig( $str = '' )
   {
   	\nn\t3::Registry()->addPageConfig( $str );
   }
   

