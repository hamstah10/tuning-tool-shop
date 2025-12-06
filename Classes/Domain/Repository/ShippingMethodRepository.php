<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\ShippingMethod;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ShippingMethodRepository extends Repository
{
    protected $defaultOrderings = [
        'sortOrder' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findActive(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isActive', true)
        );
        return $query->execute();
    }

    public function findByUidIgnoreStorage(int $uid): ?ShippingMethod
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->equals('uid', $uid)
        );
        return $query->execute()->getFirst();
    }

    public function countAll(): int
    {
        return $this->createQuery()->execute()->count();
    }
}
