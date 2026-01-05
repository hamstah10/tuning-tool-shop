
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getL18nFolderpath:

==============================================
TranslationHelper::getL18nFolderpath()
==============================================

\\nn\\t3::TranslationHelper()->getL18nFolderpath();
----------------------------------------------

Gibt den aktuellen Ordner zurück, in dem die Übersetzungs-Dateien gecached werden.
Default ist ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->getL18nFolderpath();

| ``@return  string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getL18nFolderpath() {
   	return $this->l18nFolderpath;
   }
   

