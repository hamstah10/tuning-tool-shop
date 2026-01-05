
.. include:: ../../../../Includes.txt

.. _Settings-setExtConf:

==============================================
Settings::setExtConf()
==============================================

\\nn\\t3::Settings()->setExtConf(``$extName = '', $key = '', $value = ''``);
----------------------------------------------

Write extension configuration.
Writes an extension configuration in the ``LocalConfiguration.php.`` The values can also be
corresponding configuration in ``ext_conf_template.txt``, the values can also be edited via the Extension Manager / the
Extension configuration in the backend.

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
   

