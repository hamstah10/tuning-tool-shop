<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CartItemRepository extends Repository
{
    protected $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_ASCENDING,
    ];

    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findBySessionId(string $sessionId): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('sessionId', $sessionId)
        );
        return $query->execute();
    }

    public function findByFeUser(int $feUserUid): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $feUserUid)
        );
        return $query->execute();
    }

    public function findByFeUserAndProduct(int $feUserUid, int $productUid): ?object
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('feUser', $feUserUid),
                $query->equals('product', $productUid)
            )
        );
        return $query->execute()->getFirst();
    }

    public function removeBySessionId(string $sessionId): void
    {
        $items = $this->findBySessionId($sessionId);
        foreach ($items as $item) {
            $this->remove($item);
        }
    }

    public function findBySessionIdAndProduct(string $sessionId, int $productUid): ?object
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('sessionId', $sessionId),
                $query->equals('product', $productUid)
            )
        );
        return $query->execute()->getFirst();
    }
}
