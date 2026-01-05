
.. include:: ../../../../Includes.txt

.. _Registry-addPageConfig:

==============================================
Registry::addPageConfig()
==============================================

\\nn\\t3::Registry()->addPageConfig(``$str = ''``);
----------------------------------------------

Page-Config hinzufügen

.. code-block:: php

	\nn\t3::Registry()->addPageConfig( 'test.was = 10' );
	\nn\t3::Registry()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addPageConfig( $str = '' )
   {
   	$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig'] .= "\n" . $str;
   }
   

