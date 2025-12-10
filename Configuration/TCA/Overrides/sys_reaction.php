<?php
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('reactions')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'Shop Order',
            'value' => 'tx_tuningtoolshop_domain_model_order',
            'icon' => 'myextension-tx_myextension_domain_model_mytable-icon',
        ]
    );
}