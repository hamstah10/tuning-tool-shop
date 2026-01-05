
.. include:: ../../../../Includes.txt

.. _Settings-getExtConf:

==============================================
Settings::getExtConf()
==============================================

\\nn\\t3::Settings()->getExtConf(``$extName = ''``);
----------------------------------------------

Get extension configuration.
come from the ``LocalConfiguration.php``, are defined via the extension settings
defined in the backend or ``ext_conf_template.txt`` 

Earlier: ``$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']``

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
   

