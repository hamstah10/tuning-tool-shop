
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getEnableApi:

==============================================
TranslationHelper::getEnableApi()
==============================================

\\nn\\t3::TranslationHelper()->getEnableApi();
----------------------------------------------

Gibt zurück, ob die API aktiviert ist.

.. code-block:: php

	$translationHelper->getEnableApi(); // default: false

| ``@return  boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getEnableApi() {
   	return $this->enableApi;
   }
   

