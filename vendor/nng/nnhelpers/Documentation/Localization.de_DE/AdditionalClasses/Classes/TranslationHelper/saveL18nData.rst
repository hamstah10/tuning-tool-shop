
.. include:: ../../../../Includes.txt

.. _TranslationHelper-saveL18nData:

==============================================
TranslationHelper::saveL18nData()
==============================================

\\nn\\t3::TranslationHelper()->saveL18nData(``$data = []``);
----------------------------------------------

Komplette Sprach-Datei speichern

.. code-block:: php

	$translationHelper->saveL18nData( $data );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function saveL18nData( $data = [] ) {
   	$path = $this->getL18nPath();
   	$success = \nn\t3::File()->write($path, json_encode($data));
   	if (!$success) {
   		\nn\t3::Exception('l18n-Datei konnte nicht geschrieben werden: ' . $path);
   	}
   	$this->l18nCache = $data;
   	return $path;
   }
   

