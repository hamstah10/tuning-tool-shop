
.. include:: ../../../../Includes.txt

.. _TranslationHelper-setTargetLanguage:

==============================================
TranslationHelper::setTargetLanguage()
==============================================

\\nn\\t3::TranslationHelper()->setTargetLanguage(``$targetLanguage``);
----------------------------------------------

Setzt die Zielsprache für die Übersetzung

.. code-block:: php

	$translationHelper->setTargetLanguage( 'FR' );

| ``@param   string  $targetLanguage``  Zielsprache der Übersetzung
| ``@return  self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setTargetLanguage($targetLanguage) {
   	$this->targetLanguage = $targetLanguage;
   	return $this;
   }
   

