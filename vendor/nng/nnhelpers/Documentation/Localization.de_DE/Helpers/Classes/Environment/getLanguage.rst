
.. include:: ../../../../Includes.txt

.. _Environment-getLanguage:

==============================================
Environment::getLanguage()
==============================================

\\nn\\t3::Environment()->getLanguage();
----------------------------------------------

Die aktuelle Sprache (als Zahl) des Frontends holen.

.. code-block:: php

	\nn\t3::Environment()->getLanguage();

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLanguage () {
   	$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
   	return $languageAspect->getId();
   }
   

