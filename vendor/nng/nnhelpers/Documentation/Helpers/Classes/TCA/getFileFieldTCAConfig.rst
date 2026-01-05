
.. include:: ../../../../Includes.txt

.. _TCA-getFileFieldTCAConfig:

==============================================
TCA::getFileFieldTCAConfig()
==============================================

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
----------------------------------------------

Get FAL configuration for the TCA.

Standard config incl. image cropper, link and alternative image title
This setting changes regularly, which is quite an imposition given the number of parameters
and their changing position in the array is quite an imposition.

https://bit.ly/2SUvASe

.. code-block:: php

	\nn\t3::TCA()->getFileFieldTCAConfig('media');
	\nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);

Is used in the TCA like this:

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
   

