<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Category;
use Hamstahstudio\TuningToolShop\Domain\Model\Manufacturer;
use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ManufacturerRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ManufacturerRepository $manufacturerRepository,
    ) {}

    public function listAction(int $category = 0, int $manufacturer = 0, string $sortBy = ''): ResponseInterface
    {
        $categories = $this->categoryRepository->findAll();
        $manufacturers = $this->manufacturerRepository->findAll();
        $products = $this->productRepository->findAll();

        // Filter by category if selected
        if ($category > 0) {
            $selectedCategory = $this->categoryRepository->findByUid($category);
            if ($selectedCategory !== null) {
                $products = $this->productRepository->findByCategory($selectedCategory);
            }
        }

        // Filter by manufacturer if selected
        if ($manufacturer > 0) {
            $selectedManufacturer = $this->manufacturerRepository->findByUid($manufacturer);
            if ($selectedManufacturer !== null) {
                $products = $this->productRepository->findByManufacturer($selectedManufacturer);
            }
        }

        // Apply sorting
        $products = $this->applySorting($products, $sortBy);

        // Apply items per page limit from FlexForm or TypoScript
        $itemsPerPage = (int)($this->settings['itemsPerPage'] ?? $this-zenadfdgrfgsderv >settings['shop']['itemsPerPage'] ?? 12);
        if ($itemsPerPage > 0 && is_array($products)) {
            $products = array_slice($products, 0, $itemsPerPage);
        }

        $detailPid = (int)($this->settings['detailPid'] ?? 0);
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $sortOptions = [
            '' => 'Standard',
            'title' => 'Name A-Z',
            'title_desc' => 'Name Z-A',
            'price' => 'Preis aufsteigend',
            'price_desc' => 'Preis absteigend',
        ];

        $this->view->assignMultiple([
            'products' => $products,
            'categories' => $categories,
            'manufacturers' => $manufacturers,
            'detailPid' => $detailPid,
            'cartPid' => $cartPid,
            'selectedCategory' => $category,
            'selectedManufacturer' => $manufacturer,
            'selectedSort' => $sortBy,
            'sortOptions' => $sortOptions,
            'itemsPerPage' => $itemsPerPage,
        ]);

        return $this->htmlResponse();
    }

    protected function applySorting($products, string $sortBy)
    {
        $productsArray = $products->toArray();

        if ($sortBy === '' || count($productsArray) === 0) {
            return $productsArray;
        }

        switch ($sortBy) {
            case 'title':
                usort($productsArray, fn($a, $b) => strcmp($a->getTitle(), $b->getTitle()));
                break;
            case 'title_desc':
                usort($productsArray, fn($a, $b) => strcmp($b->getTitle(), $a->getTitle()));
                break;
            case 'price':
                usort($productsArray, fn($a, $b) => ($a->getPrice() ?? 0) <=> ($b->getPrice() ?? 0));
                break;
            case 'price_desc':
                usort($productsArray, fn($a, $b) => ($b->getPrice() ?? 0) <=> ($a->getPrice() ?? 0));
                break;
        }

        return $productsArray;
    }

    public function showAction(Product $product): ResponseInterface
    {
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $this->view->assignMultiple([
            'product' => $product,
            'cartPid' => $cartPid,
        ]);

        return $this->htmlResponse();
    }

    public function categoryAction(Category $category): ResponseInterface
    {
        $products = $this->productRepository->findByCategory($category);

        $this->view->assignMultiple([
            'category' => $category,
            'products' => $products,
        ]);

        return $this->htmlResponse();
    }

    public function manufacturerAction(Manufacturer $manufacturer): ResponseInterface
    {
        $products = $this->productRepository->findByManufacturer($manufacturer);

        $this->view->assignMultiple([
            'manufacturer' => $manufacturer,
            'products' => $products,
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(): ResponseInterface
    {
        $searchTerm = $this->request->hasArgument('search')
            ? trim((string)$this->request->getArgument('search'))
            : '';

        $products = [];
        if ($searchTerm !== '') {
            $products = $this->productRepository->findBySearchTerm($searchTerm);
        }

        $this->view->assignMultiple([
            'searchTerm' => $searchTerm,
            'products' => $products,
        ]);

        return $this->htmlResponse();
    }

    public function selectedAction(): ResponseInterface
    {
        $selectedProductUids = (string)($this->settings['selectedProducts'] ?? '');
        $products = [];

        if ($selectedProductUids !== '') {
            $uids = array_map('intval', array_filter(explode(',', $selectedProductUids)));
            foreach ($uids as $uid) {
                $product = $this->productRepository->findByUidIgnoreStorage($uid);
                if ($product !== null) {
                    $products[] = $product;
                }
            }
        }

        $shopListPid = (int)($this->settings['shopListPid'] ?? 0);
        $detailPid = (int)($this->settings['detailPid'] ?? 0);
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $this->view->assignMultiple([
            'products' => $products,
            'shopListPid' => $shopListPid,
            'detailPid' => $detailPid,
            'cartPid' => $cartPid,
        ]);

        return $this->htmlResponse();
    }
}
