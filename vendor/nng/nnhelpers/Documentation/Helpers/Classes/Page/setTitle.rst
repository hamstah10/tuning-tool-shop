
.. include:: ../../../../Includes.txt

.. _Page-setTitle:

==============================================
Page::setTitle()
==============================================

\\nn\\t3::Page()->setTitle(``$title = ''``);
----------------------------------------------

Change PageTitle (<title>-tag)
Does not work if EXT:advancedtitle is activated!

.. code-block:: php

	\nn\t3::Page()->setTitle('YEAH!');

Also available as ViewHelper:

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
   

