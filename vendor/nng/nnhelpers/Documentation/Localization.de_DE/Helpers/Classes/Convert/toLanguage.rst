
.. include:: ../../../../Includes.txt

.. _Convert-toLanguage:

==============================================
Convert::toLanguage()
==============================================

\\nn\\t3::Convert()->toLanguage(``$sysLanguageUid = NULL``);
----------------------------------------------

Konvertiert eine Sprach-ID (z.B. '0', '1') in das zweistellige
Sprachkürzel (z.B. 'de', 'en')

.. code-block:: php

	// Sprach-ID 0 -> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param int $sysLanguageUid``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toLanguage($sysLanguageUid = null)
   {
   	if (is_string($sysLanguageUid) && strlen($sysLanguageUid) == 2) {
   		return $sysLanguageUid;
   	}
   	$key = $sysLanguageUid !== null ? $sysLanguageUid : $this->initialArgument;
   	$languages = \nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');
   	return $languages[$key] ?? '';
   }
   

