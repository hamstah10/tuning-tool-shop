<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class AddProductOptionValueFields implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'addProductOptionValueFields';
    }

    public function getTitle(): string
    {
        return 'Add new fields to ProductOptionValue';
    }

    public function getDescription(): string
    {
        return 'Adds description, image, and special_price fields to tx_tuningtoolshop_domain_model_productoptionvalue table';
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_tuningtoolshop_domain_model_productoptionvalue');

        $tableName = 'tx_tuningtoolshop_domain_model_productoptionvalue';
        $columns = $connection->createSchemaManager()->listTableColumns($tableName);
        $columnNames = array_keys($columns);

        if (!in_array('description', $columnNames, true)) {
            $connection->exec("ALTER TABLE $tableName ADD COLUMN description text");
        }

        if (!in_array('image', $columnNames, true)) {
            $connection->exec("ALTER TABLE $tableName ADD COLUMN image int unsigned NOT NULL DEFAULT 0");
        }

        if (!in_array('special_price', $columnNames, true)) {
            $connection->exec("ALTER TABLE $tableName ADD COLUMN special_price decimal(10,2) NOT NULL DEFAULT 0.00");
        }

        return true;
    }

    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_tuningtoolshop_domain_model_productoptionvalue');
        $tableName = 'tx_tuningtoolshop_domain_model_productoptionvalue';
        
        try {
            $columns = $connection->createSchemaManager()->listTableColumns($tableName);
            $columnNames = array_keys($columns);

            return !in_array('description', $columnNames, true) 
                || !in_array('image', $columnNames, true)
                || !in_array('special_price', $columnNames, true);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }
}
