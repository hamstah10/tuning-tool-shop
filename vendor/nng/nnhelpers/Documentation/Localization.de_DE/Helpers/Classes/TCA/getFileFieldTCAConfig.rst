
.. include:: ../../../../Includes.txt

.. _TCA-getFileFieldTCAConfig:

==============================================
TCA::getFileFieldTCAConfig()
==============================================

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
----------------------------------------------

FAL Konfiguration für das TCA holen.

Standard-Konfig inkl. Image-Cropper, Link und alternativer Bildtitel
Diese Einstellung ändert sich regelmäßig, was bei der Menge an Parametern
und deren wechselnden Position im Array eine ziemliche Zumutung ist.

https://bit.ly/2SUvASe

.. code-block:: php

	\nn\t3::TCA()->getFileFieldTCAConfig('media');
	\nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);

Wird im TCA so eingesetzt:

.. code-block:: php

	'falprofileimage' => [
	    'config' => \nn\t3::TCA()->getFileFieldTCAConfig('falprofileimage', ['maxitems'=>1]),
	],

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFileFieldTCAConfig( $fieldName = 'media', $override = [] )
   {
   	// Vereinfachte Übergabe der Optionen
   	$options = array_merge([
   		'label' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references',
   		'maxitems' => 999,
   		'fileExtensions' => 'common-media-types',
   		// 'fileUploadAllowed' => true,
   		// 'fileByUrlAllowed' => true,
   	], $override);
   	/*
   	$config = [
   		'label' => $options['label'],
   		'appearance' => [
   			'fileUploadAllowed' => $options['fileUploadAllowed'],
   			'fileByUrlAllowed' => $options['fileByUrlAllowed'],
   		],
   		'config' => [
   			'type' => 'file',
   			'maxitems' => $options['maxitems'],
   			'allowed' => $options['fileExtensions'],
   		]
   	];
   	*/
   	$config = [
   		'type' => 'file',
   		'maxitems' => $options['maxitems'],
   		'allowed' => $options['fileExtensions'],
   	];
   	if ($childConfig = $options['overrideChildTca'] ?? false) {
   		$config['overrideChildTca'] = $childConfig;
   	}
   	return $config;
   }
   

