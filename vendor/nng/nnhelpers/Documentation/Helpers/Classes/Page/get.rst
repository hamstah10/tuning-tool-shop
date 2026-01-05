
.. include:: ../../../../Includes.txt

.. _Page-get:

==============================================
Page::get()
==============================================

\\nn\\t3::Page()->get(``$uid = NULL``);
----------------------------------------------

Get data of a page (from table "pages")

.. code-block:: php

	\nn\t3::Page()->get( $uid );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get ( $uid = null ) {
   	$pageRepository = GeneralUtility::makeInstance( PageRepository::class );
   	return $pageRepository->getPage( $uid );
   }
   

