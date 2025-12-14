<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\AbstractUpdate;

class AddFrontendUserIdAndTaxAmount extends AbstractUpdate
{
    protected string $title = 'Add frontend_user_id and tax_amount columns to orders table';

    public function executeUpdate(): bool
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionByName('Default');

        // Add frontend_user_id column
        try {
            $connection->executeStatement(
                'ALTER TABLE tx_tuningtoolshop_domain_model_order 
                 ADD COLUMN IF NOT EXISTS frontend_user_id INT(11) DEFAULT 0'
            );
        } catch (\Exception $e) {
            // Column might already exist
        }

        // Add tax_amount column
        try {
            $connection->executeStatement(
                'ALTER TABLE tx_tuningtoolshop_domain_model_order 
                 ADD COLUMN IF NOT EXISTS tax_amount DECIMAL(11,2) DEFAULT 0.00'
            );
        } catch (\Exception $e) {
            // Column might already exist
        }

        return true;
    }

    public function updateNecessary(): bool
    {
        return true;
    }

    public function getIdentifier(): string
    {
        return 'tuningToolShopAddFrontendUserIdAndTaxAmount';
    }

    public function getPrerequisites(): array
    {
        return [];
    }
}
