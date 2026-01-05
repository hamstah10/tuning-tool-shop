
.. include:: ../../../../Includes.txt

.. _Settings-getExtConf:

==============================================
Settings::getExtConf()
==============================================

\\nn\\t3::Settings()->getExtConf(``$extName = ''``);
----------------------------------------------

Extension-Konfiguration holen.
Kommen aus der ``LocalConfiguration.php``, werden über die Extension-Einstellungen
im Backend bzw. ``ext_conf_template.txt`` definiert

Früher: ``$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']``

.. code-block:: php

	\nn\t3::Settings()->getExtConf( 'extname' );

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getExtConf( $extName = '' )
   {
   	return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get($extName) ?: [];
   }
   

