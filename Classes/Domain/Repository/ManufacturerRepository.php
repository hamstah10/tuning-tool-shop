<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\Manufacturer;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ManufacturerRepository extends Repository
{
    protected $defaultOrderings = [
        'name' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findBySlug(string $slug): ?Manufacturer
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('slug', $slug)
        );
        return $query->execute()->getFirst();
    }

    public function findAllActive(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('active', true)
        );
        return $query->execute();
    }
}
