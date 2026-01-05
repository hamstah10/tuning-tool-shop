
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getMaxTranslations:

==============================================
TranslationHelper::getMaxTranslations()
==============================================

\\nn\\t3::TranslationHelper()->getMaxTranslations();
----------------------------------------------

Holt die maximale Anzahl an Übersetzungen, die pro Instanz gemacht werden sollen.

.. code-block:: php

	$translationHelper->getMaxTranslations(); // default: 0 = unendlich

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getMaxTranslations() {
   	return $this->maxTranslations;
   }
   

