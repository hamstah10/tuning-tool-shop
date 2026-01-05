
.. include:: ../../../../Includes.txt

.. _Page-getPageRenderer:

==============================================
Page::getPageRenderer()
==============================================

\\nn\\t3::Page()->getPageRenderer();
----------------------------------------------

Get page renderer

.. code-block:: php

	\nn\t3::Page()->getPageRenderer();

| ``@return PageRenderer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPageRenderer() {
   	if (\nn\t3::Environment()->isFrontend()) {
   		return GeneralUtility::makeInstance( PageRenderer::class );
   	}
   	return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
   }
   

