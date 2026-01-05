
.. include:: ../../../../Includes.txt

.. _TCA-getSlugTCAConfig:

==============================================
TCA::getSlugTCAConfig()
==============================================

\\nn\\t3::TCA()->getSlugTCAConfig(``$fields = []``);
----------------------------------------------

Get default slug configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getSlugTCAConfig( 'title' )
	'config' => \nn\t3::TCA()->getSlugTCAConfig( ['title', 'header'] )

| ``@param array|string $fields``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSlugTCAConfig( $fields = [] )
   {
   	if (is_string($fields)) {
   		$fields = [$fields];
   	}
   	return [
   		'type' => 'slug',
   		'size' => 50,
   		'generatorOptions' => [
   			'fields' => $fields,
   			'replacements' => [
   				'/' => '-'
   			],
   		],
   		'fallbackCharacter' => '-',
   		'eval' => 'unique',
   		'default' => ''
   	];
   }
   

