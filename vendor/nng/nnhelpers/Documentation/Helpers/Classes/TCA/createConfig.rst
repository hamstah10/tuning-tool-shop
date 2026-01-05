
.. include:: ../../../../Includes.txt

.. _TCA-createConfig:

==============================================
TCA::createConfig()
==============================================

\\nn\\t3::TCA()->createConfig(``$tablename = '', $basics = [], $custom = []``);
----------------------------------------------

Get basic configuration for the TCA.
These are the fields such as ``hidden``, ``starttime`` etc., which are always the same for (almost) all tables.

Get ALL typical fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry', true,
	    ['title'=>...]
	)

Get only certain fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry',
	    ['sys_language_uid', 'l10n_parent', 'l10n_source', 'l10n_diffsource', 'hidden', 'cruser_id', 'pid', 'crdate', 'tstamp', 'sorting', 'starttime', 'endtime', 'fe_group'],
	    ['title'=>...]
	)

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createConfig( $tablename = '', $basics = [], $custom = [] )
   {
   	if ($basics === true) {
   		$basics = ['sys_language_uid', 'l10n_parent', 'l10n_source', 'l10n_diffsource', 'hidden', 'cruser_id', 'pid', 'crdate', 'tstamp', 'sorting', 'starttime', 'endtime', 'fe_group'];
   	}
   	$defaults = [
   		'sys_language_uid' => [
   			'exclude' => true,
   			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
   			'config' => [
   				'type' => 'language',
   			]
   		],
   		'l10n_parent' => [
   			'displayCond' => 'FIELD:sys_language_uid:>:0',
   			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
   			'config' => [
   				'type' => 'select',
   				'renderType' => 'selectSingle',
   				'items' => [
   					[
   						'label' => '',
   						'value' => 0,
   					]
   				],
   				'foreign_table' => $tablename,
   				'foreign_table_where' => 'AND {#' . $tablename . '}.{#pid}=###CURRENT_PID### AND {#' . $tablename . '}.{#sys_language_uid} IN (-1,0)',
   				'default' => 0,
   			],
   		],
   		'l10n_source' => [
   			'config' => [
   				'type' => 'passthrough'
   			]
   		],
   		'l10n_diffsource' => [
   			'config' => [
   				'type' => 'passthrough',
   				'default' => ''
   			]
   		],
   		'hidden' => [
   			'exclude' => true,
   			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
   			'config' => [
   				'type' => 'check',
   				'renderType' => 'checkboxToggle',
   				'default' => 0,
   			]
   		],
   		'cruser_id' => [
   			'label' => 'cruser_id',
   			'config' => [
   				'type' => 'passthrough'
   			]
   		],
   		'pid' => [
   			'label' => 'pid',
   			'config' => [
   				'type' => 'passthrough'
   			]
   		],
   		'crdate' => [
   			'label' => 'crdate',
   			'config' => [
   				'type' => 'input',
   			]
   		],
   		'tstamp' => [
   			'label' => 'tstamp',
   			'config' => [
   				'type' => 'input',
   			]
   		],
   		'sorting' => [
   			'label' => 'sorting',
   			'config' => [
   				'type' => 'passthrough',
   			]
   		],
   		'starttime' => [
   			'exclude' => true,
   			'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel',
   			'config' => [
   				'type' => 'datetime',
   				'default' => 0,
   				'behaviour' => [
   					'allowLanguageSynchronization' => true,
   				],
   			]
   		],
   		'endtime' => [
   			'exclude' => true,
   			'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
   			'config' => [
   				'type' => 'datetime',
   				'default' => 0,
   				'range' => [
   					'upper' => mktime(0, 0, 0, 1, 1, 2038),
   				],
   				'behaviour' => [
   					'allowLanguageSynchronization' => true,
   				],
   			]
   		],
   		'fe_group' => [
   			'exclude' => true,
   			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
   			'config' => [
   				'type' => 'select',
   				'renderType' => 'selectMultipleSideBySide',
   				'size' => 5,
   				'maxitems' => 20,
   				'items' => [
   					[
   						'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login',
   						'value' => -1,
   					],
   					[
   						'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login',
   						'value' => -2,
   					],
   					[
   						'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups',
   						'value' => '--div--',
   					],
   				],
   				'exclusiveKeys' => '-1,-2',
   				'foreign_table' => 'fe_groups',
   				'foreign_table_where' => 'ORDER BY fe_groups.title',
   			],
   		],
   	];
   	$result = [];
   	foreach ($basics as $key) {
   		if ($config = $defaults[$key] ?? false) {
   			$result[$key] = $config;
   		}
   	}
   	return array_merge( $result, $custom );
   }
   

