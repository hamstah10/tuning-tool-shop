
.. include:: ../../../../Includes.txt

.. _Page-getTitle:

==============================================
Page::getTitle()
==============================================

\\nn\\t3::Page()->getTitle();
----------------------------------------------

Aktuellen Page-Title (ohne Suffix) holen

.. code-block:: php

	\nn\t3::Page()->getTitle();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTitle () {
   	$titleProvider = GeneralUtility::makeInstance( PageTitleProvider::class );
   	return $titleProvider->getRawTitle();
   }
   

