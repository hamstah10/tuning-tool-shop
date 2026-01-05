
.. include:: ../../../../Includes.txt

.. _Settings-setExtConf:

==============================================
Settings::setExtConf()
==============================================

\\nn\\t3::Settings()->setExtConf(``$extName = '', $key = '', $value = ''``);
----------------------------------------------

Extension-Konfiguration schreiben.
Schreibt eine Extension-Konfiguration in die ``LocalConfiguration.php``. Die Werte können bei
entsprechender Konfiguration in der ``ext_conf_template.txt`` auch über den Extension-Manager / die
Extension Konfiguration im Backend bearbeitet werden.

.. code-block:: php

	\nn\t3::Settings()->setExtConf( 'extname', 'key', 'value' );

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setExtConf( $extName = '', $key = '', $value = '' )
   {
   	$coreConfigurationManager = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ConfigurationManager::class);
   	$result = $coreConfigurationManager->setLocalConfigurationValueByPath("EXTENSIONS/{$extName}/{$key}", $value);
   	return $result;
   }
   

