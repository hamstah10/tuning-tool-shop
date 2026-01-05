<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Migrations\Code;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class Version20251226000000AddPaymentMethodCredentials
{
    public function up(): void
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionForTable('tx_tuningtoolshop_domain_model_paymentmethod');
        
        // Check if columns already exist
        $sm = $connection->createSchemaManager();
        $columns = $sm->listTableColumns('tx_tuningtoolshop_domain_model_paymentmethod');
        
        if (!isset($columns['client_id'])) {
            $connection->executeQuery('
                ALTER TABLE tx_tuningtoolshop_domain_model_paymentmethod 
                ADD COLUMN client_id varchar(500) NOT NULL DEFAULT \'\'
            ');
        }
        
        if (!isset($columns['secret'])) {
            $connection->executeQuery('
                ALTER TABLE tx_tuningtoolshop_domain_model_paymentmethod 
                ADD COLUMN secret varchar(500) NOT NULL DEFAULT \'\'
            ');
        }
    }

    public function down(): void
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionForTable('tx_tuningtoolshop_domain_model_paymentmethod');
        
        // Check if columns exist before dropping
        $sm = $connection->createSchemaManager();
        $columns = $sm->listTableColumns('tx_tuningtoolshop_domain_model_paymentmethod');
        
        if (isset($columns['client_id'])) {
            $connection->executeQuery('
                ALTER TABLE tx_tuningtoolshop_domain_model_paymentmethod 
                DROP COLUMN client_id
            ');
        }
        
        if (isset($columns['secret'])) {
            $connection->executeQuery('
                ALTER TABLE tx_tuningtoolshop_domain_model_paymentmethod 
                DROP COLUMN secret
            ');
        }
    }
}
