
.. include:: ../../../../Includes.txt

.. _TranslationHelper-loadL18nData:

==============================================
TranslationHelper::loadL18nData()
==============================================

\\nn\\t3::TranslationHelper()->loadL18nData();
----------------------------------------------

Load complete language file.

.. code-block:: php

	$translationHelper->loadL18nData();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function loadL18nData() {
   	if ($cache = $this->l18nCache) return $cache;
   	$path = $this->getL18nPath();
   	$data = json_decode( \nn\t3::File()->read($path), true ) ?: [];
   	return $this->l18nCache = $data;
   }
   

