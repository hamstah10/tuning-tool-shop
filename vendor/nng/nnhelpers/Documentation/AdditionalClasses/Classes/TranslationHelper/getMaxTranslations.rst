
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getMaxTranslations:

==============================================
TranslationHelper::getMaxTranslations()
==============================================

\\nn\\t3::TranslationHelper()->getMaxTranslations();
----------------------------------------------

Gets the maximum number of translations to be made per instance.

.. code-block:: php

	$translationHelper->getMaxTranslations(); // default: 0 = infinite

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getMaxTranslations() {
   	return $this->maxTranslations;
   }
   

