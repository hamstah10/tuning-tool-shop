
.. include:: ../../../../Includes.txt

.. _TranslationHelper-setL18nFolderpath:

==============================================
TranslationHelper::setL18nFolderpath()
==============================================

\\nn\\t3::TranslationHelper()->setL18nFolderpath(``$l18nFolderpath``);
----------------------------------------------

[Translate to EN] Setzt den aktuellen Ordner, in dem die Übersetzungs-Dateien gecached werden.
Idee ist es, die übersetzten Texte für Backend-Module nur 1x zu übersetzen und dann in dem Extension-Ordner zu speichern.
Von dort werden sie dann ins GIT deployed.

Default ist ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->setL18nFolderpath('EXT:myext/Resources/Private/Language/');

| ``@param   string  $l``18nFolderpath  Pfad zum Ordner mit den Übersetzungsdateien (JSON)
| ``@return  self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setL18nFolderpath($l18nFolderpath) {
   	$this->l18nFolderpath = $l18nFolderpath;
   	return $this;
   }
   

