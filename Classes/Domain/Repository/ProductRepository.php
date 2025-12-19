<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use Hamstahstudio\TuningToolShop\Domain\Model\Category;
use Hamstahstudio\TuningToolShop\Domain\Model\Manufacturer;
use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use Hamstahstudio\TuningToolShop\Domain\Model\Tag;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ProductRepository extends Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findByUidIgnoreStorage(int $uid): ?Product
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->equals('uid', $uid)
        );
        return $query->execute()->getFirst();
    }

    public function findByCategory(Category $category): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->contains('categories', $category)
        );
        return $query->execute();
    }

    public function findByManufacturer(Manufacturer $manufacturer): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('manufacturer', $manufacturer)
        );
        return $query->execute();
    }

    public function findBySlug(string $slug): ?Product
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('slug', $slug)
        );
        return $query->execute()->getFirst();
    }

    public function findActive(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('active', true)
        );
        return $query->execute();
    }

    public function findFeatured(int $limit = 10): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('featured', true),
                $query->equals('active', true)
            )
        );
        $query->setLimit($limit);
        return $query->execute();
    }

    public function searchByTerm(string $term): QueryResultInterface
    {
        $query = $this->createQuery();
        $searchTerm = '%' . $term . '%';
        $query->matching(
            $query->logicalAnd(
                $query->equals('isActive', true),
                $query->logicalOr(
                    $query->like('title', $searchTerm),
                    $query->like('description', $searchTerm),
                    $query->like('sku', $searchTerm)
                )
            )
        );
        return $query->execute();
    }

    public function findBySearchTerm(string $term): QueryResultInterface
    {
        return $this->searchByTerm($term);
    }

    public function findRecent(int $limit = 10): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isActive', true)
        );
        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit($limit);
        return $query->execute();
    }

    public function findAllIgnoreStorage(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query->execute();
    }

    public function countAll(): int
    {
        return $this->findAllIgnoreStorage()->count();
    }

    public function findByTag(Tag $tag): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->contains('tags', $tag)
        );
        return $query->execute();
    }

    /**
     * Find products by an array of UIDs
     *
     * @param array<int> $ids
     * @return QueryResultInterface
     */
    public function findByIds(array $ids): QueryResultInterface
    {
        if (empty($ids)) {
            return $this->createQuery()->execute();
        }

        $query = $this->createQuery();
        $constraints = [];

        foreach ($ids as $id) {
            $constraints[] = $query->equals('uid', (int)$id);
        }

        if (count($constraints) === 1) {
            $query->matching($constraints[0]);
        } else {
            $query->matching($query->logicalOr(...$constraints));
        }

        return $query->execute();
    }
}
