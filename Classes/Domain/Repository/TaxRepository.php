<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\Tax;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class TaxRepository extends Repository
{
    protected $defaultOrderings = [
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findDefault(): ?Tax
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isDefault', true)
        );
        return $query->execute()->getFirst();
    }

    public function findByCountry(string $country): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('country', $country)
        );
        return $query->execute();
    }
}
