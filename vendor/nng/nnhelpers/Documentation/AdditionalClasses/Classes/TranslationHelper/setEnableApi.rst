
.. include:: ../../../../Includes.txt

.. _TranslationHelper-setEnableApi:

==============================================
TranslationHelper::setEnableApi()
==============================================

\\nn\\t3::TranslationHelper()->setEnableApi(``$enableApi``);
----------------------------------------------

[Translate to EN] Aktiviert / Deaktiviert die Übersetzung per Deep-L.

.. code-block:: php

	$translationHelper->setEnableApi( true ); // default: false

| ``@param   boolean  $enableApi``
| ``@return  self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setEnableApi($enableApi) {
   	$this->enableApi = $enableApi;
   	return $this;
   }
   

