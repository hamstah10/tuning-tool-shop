<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class OrderRepository extends Repository
{
    protected $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_DESCENDING,
    ];

    protected $defaultQuerySettings = null;

    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setIgnoreEnableFields(false);
        $querySettings->setRespectStoragePage(false);
        $this->defaultQuerySettings = $querySettings;
    }

    protected function getQuery(): QueryInterface
    {
        $query = $this->createQuery();
        if ($this->defaultQuerySettings !== null) {
            $query->setQuerySettings($this->defaultQuerySettings);
        }
        return $query;
    }

    public function findByOrderNumber(string $orderNumber): ?Order
    {
        $query = $this->getQuery();
        $query->matching(
            $query->equals('orderNumber', $orderNumber)
        );
        return $query->execute()->getFirst();
    }

    public function findByCustomerEmail(string $email): QueryResultInterface
    {
        $query = $this->getQuery();
        $query->matching(
            $query->equals('customerEmail', $email)
        );
        return $query->execute();
    }

    public function findByStatus(int $status): QueryResultInterface
    {
        $query = $this->getQuery();
        $query->matching(
            $query->equals('status', $status)
        );
        return $query->execute();
    }

    public function countByStatus(int $status): int
    {
        $query = $this->getQuery();
        $query->matching(
            $query->equals('status', $status)
        );
        return $query->execute()->count();
    }

    public function findRecent(int $limit = 10): QueryResultInterface
    {
        $query = $this->getQuery();
        $query->setLimit($limit);
        return $query->execute();
    }

    public function findOneByTransactionId(string $transactionId): ?Order
    {
        $query = $this->getQuery();
        $query->matching(
            $query->equals('transactionId', $transactionId)
        );
        return $query->execute()->getFirst();
    }

    public function countAll(): int
    {
        return $this->getQuery()->execute()->count();
    }
}
