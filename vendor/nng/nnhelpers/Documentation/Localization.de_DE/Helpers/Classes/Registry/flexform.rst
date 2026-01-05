
.. include:: ../../../../Includes.txt

.. _Registry-flexform:

==============================================
Registry::flexform()
==============================================

\\nn\\t3::Registry()->flexform(``$vendorName = '', $pluginName = '', $path = ''``);
----------------------------------------------

Ein Flexform für ein Plugin registrieren.

.. code-block:: php

	\nn\t3::Registry()->flexform( 'nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );
	\nn\t3::Registry()->flexform( 'Nng\Nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function flexform ( $vendorName = '', $pluginName = '', $path = '' )
   {
   	// \Nng\Nnsite => nnsite
   	$extName = strtolower( array_pop(explode('\\', $vendorName)) );
   	$pluginKey = "{$extName}_{$pluginName}";
   	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginKey] = 'pi_flexform';
   	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginKey, $path);
   }
   

