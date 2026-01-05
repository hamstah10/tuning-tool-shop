
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getL18nFolderpath:

==============================================
TranslationHelper::getL18nFolderpath()
==============================================

\\nn\\t3::TranslationHelper()->getL18nFolderpath();
----------------------------------------------

Returns the current folder in which the translation files are cached.
Default is ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->getL18nFolderpath();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getL18nFolderpath() {
   	return $this->l18nFolderpath;
   }
   

