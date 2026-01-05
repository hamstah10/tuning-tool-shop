
.. include:: ../../../../Includes.txt

.. _Page-setTitle:

==============================================
Page::setTitle()
==============================================

\\nn\\t3::Page()->setTitle(``$title = ''``);
----------------------------------------------

PageTitle (<title>-Tag) ändern
Funktioniert nicht, wenn EXT:advancedtitle aktiviert ist!

.. code-block:: php

	\nn\t3::Page()->setTitle('YEAH!');

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:page.title(title:'Yeah')}
	{entry.title->nnt3:page.title()}

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setTitle ( $title = '' ) {
   	$titleProvider = GeneralUtility::makeInstance( PageTitleProvider::class );
   	$titleProvider->setTitle( htmlspecialchars(strip_tags($title)) );
   }
   

