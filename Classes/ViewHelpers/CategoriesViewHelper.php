<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ManufacturerRepository;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class CategoriesViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function __construct(
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ManufacturerRepository $manufacturerRepository,
    ) {}

    public function initializeArguments(): void
    {
        $this->registerArgument('type', 'string', 'Type to fetch: categories, manufacturers, children', false, 'categories');
        $this->registerArgument('parentUid', 'int', 'Parent category UID for children lookup', false, null);
    }

    public function render(): mixed
    {
        $type = $this->arguments['type'];
        $parentUid = $this->arguments['parentUid'];

        if ($type === 'categories') {
            return $this->getCategories();
        }

        if ($type === 'children' && $parentUid !== null) {
            return $this->getChildren($parentUid);
        }

        if ($type === 'manufacturers') {
            return $this->getManufacturers();
        }

        return [];
    }

    private function getCategories(): mixed
    {
        $query = $this->categoryRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('parent', 0));
        $query->setOrderings(['sorting' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }

    private function getChildren(int $parentUid): mixed
    {
        $query = $this->categoryRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('parent', $parentUid));
        $query->setOrderings(['sorting' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }

    private function getManufacturers(): mixed
    {
        $query = $this->manufacturerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }
}
