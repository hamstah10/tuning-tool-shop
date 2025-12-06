<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\PaymentMethod;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PaymentMethodRepository extends Repository
{
    protected $defaultOrderings = [
        'sortOrder' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findAllActive(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('active', true)
        );
        return $query->execute();
    }

    public function findByUidIgnoreStorage(int $uid): ?PaymentMethod
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->equals('uid', $uid)
        );
        return $query->execute()->getFirst();
    }
}
