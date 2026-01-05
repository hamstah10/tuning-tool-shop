
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getTargetLanguage:

==============================================
TranslationHelper::getTargetLanguage()
==============================================

\\nn\\t3::TranslationHelper()->getTargetLanguage();
----------------------------------------------

Holt die Zielsprache für die Übersetzung

.. code-block:: php

	$translationHelper->getTargetLanguage(); // Default: EN

| ``@return  string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTargetLanguage() {
   	return $this->targetLanguage;
   }
   

