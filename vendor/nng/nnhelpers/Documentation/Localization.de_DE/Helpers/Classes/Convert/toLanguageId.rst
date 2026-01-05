
.. include:: ../../../../Includes.txt

.. _Convert-toLanguageId:

==============================================
Convert::toLanguageId()
==============================================

\\nn\\t3::Convert()->toLanguageId(``$languageCode = NULL``);
----------------------------------------------

Konvertiert ein zweistelliges Sprachkürzel (z.B. 'de', 'en')
in die Sprach-ID (z.B. '0', '1')

.. code-block:: php

	// Sprach-ID 0 -> 'de'
	\nn\t3::Convert('de')->toLanguageId();

| ``@param int $sysLanguageUid``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toLanguageId($languageCode = null)
   {
   	if (is_numeric($languageCode)) {
   		return $languageCode;
   	}
   	$key = $languageCode !== null ? $languageCode : $this->initialArgument;
   	$languages = \nn\t3::Environment()->getLanguages('iso-639-1', 'languageId');
   	return $languages[$key] ?? '';
   }
   

