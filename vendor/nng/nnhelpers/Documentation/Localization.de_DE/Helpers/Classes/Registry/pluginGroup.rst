
.. include:: ../../../../Includes.txt

.. _Registry-pluginGroup:

==============================================
Registry::pluginGroup()
==============================================

\\nn\\t3::Registry()->pluginGroup(``$vendorName = '', $groupLabel = '', $plugins = []``);
----------------------------------------------

Vereinfacht das Registrieren einer Liste von Plugins, die im ``list_type`` Dropdown zu einer
Gruppe zusammengefasst werden.

In ``Configuration/TCA/Overrides/tt_content.php`` nutzen:

.. code-block:: php

	\nn\t3::Registry()->pluginGroup(
	    'Nng\Myextname',
	    'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_group_name',
	    [
	        'list' => [
	            'title'       => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_list.name',
	            'icon'        => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform'    => 'FILE:EXT:myextname/Configuration/FlexForm/list.xml',
	        ],
	        'show' => [
	            'title'       => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_show.name',
	            'icon'        => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform'    => 'FILE:EXT:myextname/Configuration/FlexForm/show.xml'
	        ],
	    ]
	);

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function pluginGroup ( $vendorName = '', $groupLabel = '', $plugins = [] )
   {
   	// My\ExtName => ext_name
   	$extName = GeneralUtility::camelCaseToLowerCaseUnderscored(array_pop(explode('\\', $vendorName)));
   	$groupName = $extName . '_group';
   	// ab TYPO3 10 können im Plugin-Dropdown optgroups gebildet werden
   	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup( 'tt_content', 'list_type', $groupName, $groupLabel, 'before:default' );
   	foreach ($plugins as $listType=>$config) {
   		$this->plugin( $vendorName, $listType, $config['title'] ?? '', $config['icon'] ?? '', $groupName );
   		if ($flexform = $config['flexform'] ?? false) {
   			$this->flexform( $vendorName, $listType, $flexform );
   		}
   	}
   }
   

