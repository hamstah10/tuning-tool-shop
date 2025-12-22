<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CategoryController extends ActionController
{
    public function __construct(
        protected readonly CategoryRepository $categoryRepository
    ) {}

    public function listAction(): ResponseInterface
    {
        $categories = $this->categoryRepository->findAll();
        $this->view->assign('categories', $categories);
        return $this->htmlResponse();
    }
}
