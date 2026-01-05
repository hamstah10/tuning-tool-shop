
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getTargetLanguage:

==============================================
TranslationHelper::getTargetLanguage()
==============================================

\\nn\\t3::TranslationHelper()->getTargetLanguage();
----------------------------------------------

Gets the target language for the translation

.. code-block:: php

	$translationHelper->getTargetLanguage(); // Default: EN

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTargetLanguage() {
   	return $this->targetLanguage;
   }
   

