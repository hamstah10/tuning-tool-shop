
.. include:: ../../../../Includes.txt

.. _TranslationHelper-getEnableApi:

==============================================
TranslationHelper::getEnableApi()
==============================================

\\nn\\t3::TranslationHelper()->getEnableApi();
----------------------------------------------

Returns whether the API is enabled.

.. code-block:: php

	$translationHelper->getEnableApi(); // default: false

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getEnableApi() {
   	return $this->enableApi;
   }
   

