<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class CategoriesViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function __construct(
        protected readonly CategoryRepository $categoryRepository,
    ) {}

    public function initializeArguments(): void
    {
        $this->registerArgument('type', 'string', 'Type of categories to fetch: root or children', false, 'root');
        $this->registerArgument('parentUid', 'int', 'Parent category UID for children lookup', false, null);
    }

    public function render(): mixed
    {
        $type = $this->arguments['type'];
        $parentUid = $this->arguments['parentUid'];

        // Get all categories first (without storage restrictions)
        $query = $this->categoryRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        if ($type === 'root') {
            $query->matching($query->equals('parent', 0));
            $query->setOrderings(['sorting' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING]);
            return $query->execute();
        }

        if ($type === 'children' && $parentUid !== null) {
            $query->matching($query->equals('parent', $parentUid));
            $query->setOrderings(['sorting' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING]);
            return $query->execute();
        }

        return [];
    }
}
