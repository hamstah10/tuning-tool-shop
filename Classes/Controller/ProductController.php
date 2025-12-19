<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Category;
use Hamstahstudio\TuningToolShop\Domain\Model\Manufacturer;
use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use Hamstahstudio\TuningToolShop\Domain\Model\Tag;
use Hamstahstudio\TuningToolShop\Domain\Repository\CategoryRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ManufacturerRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\TagRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ManufacturerRepository $manufacturerRepository,
        protected readonly TagRepository $tagRepository,
    ) {}

    public function listAction(int $category = 0, int $manufacturer = 0, string $sortBy = ''): ResponseInterface
    {
        $categories = $this->categoryRepository->findAll();
        $manufacturers = $this->manufacturerRepository->findAll();
        $products = $this->productRepository->findAll();

        // Convert ObjectStorage to array if needed for backend filtering
        $productsArray = is_array($products) ? $products : $products->toArray();
        
        // Apply backend filter settings if configured
        $backendCategories = $this->settings['categories'] ?? null;
        $backendManufacturers = $this->settings['manufacturers'] ?? null;
        
        if ($backendCategories !== null && $backendCategories !== '') {
            // Filter products by backend-selected categories
            $categoryIds = is_array($backendCategories) ? $backendCategories : explode(',', (string)$backendCategories);
            $categoryIds = array_map('strval', array_filter(array_map('trim', $categoryIds)));
            
            $filteredProducts = [];
            foreach ($productsArray as $product) {
                foreach ($product->getCategories() as $productCategory) {
                    if (in_array((string)$productCategory->getUid(), $categoryIds, true)) {
                        $filteredProducts[$product->getUid()] = $product;
                        break;
                    }
                }
            }
            $productsArray = array_values($filteredProducts);
        }
        
        if ($backendManufacturers !== null && $backendManufacturers !== '') {
            // Filter products by backend-selected manufacturers
            $manufacturerIds = is_array($backendManufacturers) ? $backendManufacturers : explode(',', (string)$backendManufacturers);
            $manufacturerIds = array_map('strval', array_filter(array_map('trim', $manufacturerIds)));
            
            $productsArray = array_filter($productsArray, function($product) use ($manufacturerIds) {
                $manufacturer = $product->getManufacturer();
                return $manufacturer !== null && in_array((string)$manufacturer->getUid(), $manufacturerIds, true);
            });
            $productsArray = array_values($productsArray);
        }
        
        $products = $productsArray;

        // Frontend filter by category if selected via form
        if ($category > 0) {
            $selectedCategory = $this->categoryRepository->findByUid($category);
            if ($selectedCategory !== null) {
                $products = $this->productRepository->findByCategory($selectedCategory);
            }
        }

        // Frontend filter by manufacturer if selected via form
        if ($manufacturer > 0) {
            $selectedManufacturer = $this->manufacturerRepository->findByUid($manufacturer);
            if ($selectedManufacturer !== null) {
                $products = $this->productRepository->findByManufacturer($selectedManufacturer);
            }
        }

        // Apply sorting
        $products = $this->applySorting($products, $sortBy);

        // Apply items per page limit from FlexForm or TypoScript
        $itemsPerPage = (int)($this->settings['itemsPerPage'] ?? $this->settings['shop']['itemsPerPage'] ?? 12);
        $currentPage = (int)($this->request->hasArgument('currentPage') ? $this->request->getArgument('currentPage') : 1);
        
        $totalProducts = is_array($products) ? count($products) : $products->count();
        $totalPages = $itemsPerPage > 0 ? ceil($totalProducts / $itemsPerPage) : 1;
        
        if ($itemsPerPage > 0 && is_array($products)) {
            $offset = ($currentPage - 1) * $itemsPerPage;
            $products = array_slice($products, $offset, $itemsPerPage);
        }

        // Build pagination data
        $pagination = [
            'numberOfPages' => $totalPages,
            'currentPage' => $currentPage,
            'previousPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'nextPage' => $currentPage < $totalPages ? $currentPage + 1 : null,
            'pages' => [],
        ];
        
        for ($i = 1; $i <= $totalPages; $i++) {
            $pagination['pages'][] = [
                'number' => $i,
                'isCurrent' => $i === $currentPage,
            ];
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

        // Convert ObjectStorage to array for template
        $categoriesArray = is_array($categories) ? $categories : $categories->toArray();
        $manufacturersArray = is_array($manufacturers) ? $manufacturers : $manufacturers->toArray();

        $this->view->assignMultiple([
            'products' => $products,
            'pagination' => $pagination,
            'categories' => $categoriesArray,
            'manufacturers' => $manufacturersArray,
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
        // Convert to array if ObjectStorage
        $productsArray = is_array($products) ? $products : $products->toArray();

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

    public function tagAction(Tag $tag): ResponseInterface
    {
        $products = $this->productRepository->findByTag($tag);
        $detailPid = (int)($this->settings['detailPid'] ?? 0);
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $this->view->assignMultiple([
            'tag' => $tag,
            'products' => $products,
            'detailPid' => $detailPid,
            'cartPid' => $cartPid,
        ]);

        return $this->htmlResponse();
    }
}
