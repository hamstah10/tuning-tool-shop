
.. include:: ../../../../Includes.txt

.. _TranslationHelper-setMaxTranslations:

==============================================
TranslationHelper::setMaxTranslations()
==============================================

\\nn\\t3::TranslationHelper()->setMaxTranslations(``$maxTranslations``);
----------------------------------------------

[Translate to EN] Setzt die maximale Anzahl an Übersetzungen, die pro Instanz gemacht werden sollen.
Hilft beim Debuggen (damit das Deep-L Kontingent nicht durch Testings ausgeschöpft wird) und bei TimeOuts, wenn viele Texte übersetzt werden müssen.

.. code-block:: php

	$translationHelper->setMaxTranslations( 5 ); // Nach 5 Übersetzungen abbrechen

| ``@param   $maxTranslations``
| ``@return  self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setMaxTranslations($maxTranslations) {
   	$this->maxTranslations = $maxTranslations;
   	return $this;
   }
   

