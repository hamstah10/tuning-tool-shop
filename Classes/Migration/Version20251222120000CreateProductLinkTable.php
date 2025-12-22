<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Migration;

use Doctrine\DBAL\Schema\Schema;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class Version20251222120000CreateProductLinkTable implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'tuning_tool_shop_create_productlink_table';
    }

    public function getTitle(): string
    {
        return 'Create tx_tuningtoolshop_domain_model_productlink table';
    }

    public function getDescription(): string
    {
        return 'Creates the new table for storing product links as individual records.';
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionByName(ConnectionPool::DEFAULT_CONNECTION_NAME);
        $schemaManager = $connection->createSchemaManager();
        $schema = $schemaManager->introspectSchema();

        if (!$schema->hasTable('tx_tuningtoolshop_domain_model_productlink')) {
            $sql = <<<SQL
            CREATE TABLE `tx_tuningtoolshop_domain_model_productlink` (
              `uid` int(11) NOT NULL AUTO_INCREMENT,
              `pid` int(11) NOT NULL DEFAULT 0,
              `tstamp` int(11) NOT NULL DEFAULT 0,
              `crdate` int(11) NOT NULL DEFAULT 0,
              `deleted` tinyint(4) NOT NULL DEFAULT 0,
              `hidden` tinyint(4) NOT NULL DEFAULT 0,
              `sorting` int(11) NOT NULL DEFAULT 0,
              `product` int(11) NOT NULL DEFAULT 0,
              `title` varchar(255) NOT NULL DEFAULT '',
              `url` text NOT NULL,
              PRIMARY KEY (`uid`),
              KEY `parent` (`pid`),
              KEY `product` (`product`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL;

            $connection->executeStatement($sql);
        }

        return true;
    }

    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionByName(ConnectionPool::DEFAULT_CONNECTION_NAME);
        $schemaManager = $connection->createSchemaManager();
        $schema = $schemaManager->introspectSchema();

        return !$schema->hasTable('tx_tuningtoolshop_domain_model_productlink');
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }
}
