<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CategoryRepository extends Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findByParent(int $parentUid): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('parent', $parentUid)
        );
        return $query->execute();
    }

    public function findRootCategories(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('parent', 0)
        );
        return $query->execute();
    }

    public function findBySlug(string $slug): ?Category
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('slug', $slug)
        );
        return $query->execute()->getFirst();
    }
}
