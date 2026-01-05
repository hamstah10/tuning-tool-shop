
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getL18nPath:

==============================================
TranslationHelper::getL18nPath()
==============================================

\\nn\\t3::TranslationHelper()->getL18nPath();
----------------------------------------------

Absoluten Pfad zur l18n-Cache-Datei zurückgeben.
Default ist ``typo3conf/l10n/nnhelpers/[LANG].autotranslated.json``

.. code-block:: php

	$translationHelper->getL18nPath();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getL18nPath() {
   	$path = rtrim($this->getL18nFolderpath(), '/').'/';
   	$file = \nn\t3::File()->absPath( $path . strtolower($this->targetLanguage) . '.autotranslated.json' );
   	return $file;
   }
   

