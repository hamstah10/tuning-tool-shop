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

    public function findByOrderNumber(string $orderNumber): ?Order
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('orderNumber', $orderNumber)
        );
        return $query->execute()->getFirst();
    }

    public function findByCustomerEmail(string $email): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('customerEmail', $email)
        );
        return $query->execute();
    }

    public function findByStatus(int $status): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status)
        );
        return $query->execute();
    }

    public function countByStatus(int $status): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status)
        );
        return $query->execute()->count();
    }

    public function findRecent(int $limit = 10): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->setLimit($limit);
        return $query->execute();
    }

    public function findOneByTransactionId(string $transactionId): ?Order
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('transactionId', $transactionId)
        );
        return $query->execute()->getFirst();
    }

    public function countAll(): int
    {
        return $this->createQuery()->execute()->count();
    }
}
