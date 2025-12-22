<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Tag;
use Hamstahstudio\TuningToolShop\Domain\Repository\TagRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TagController extends ActionController
{
    public function __construct(
        protected readonly TagRepository $tagRepository,
        protected readonly ProductRepository $productRepository
    ) {}

    public function listAction(): ResponseInterface
    {
        $tags = $this->tagRepository->findAll();
        $this->view->assign('tags', $tags);
        return $this->htmlResponse();
    }

    public function showAction(Tag $tag): ResponseInterface
    {
        $products = $this->productRepository->findByTag($tag);
        $this->view->assign('tag', $tag);
        $this->view->assign('products', $products);
        return $this->htmlResponse();
    }
}
