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
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class AdminController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ManufacturerRepository $manufacturerRepository,
        protected readonly LoggerInterface $logger,
        protected readonly Context $context,
    ) {}

    /**
     * Check if user is authenticated
     */
    protected function requireAuth(): bool
    {
        return $this->getCurrentFrontendUser() !== null;
    }

    /**
     * Dashboard action
     */
    public function dashboardAction(): ResponseInterface
    {
        $feUser = $this->getCurrentFrontendUser();
        
        $products = $this->productRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $manufacturers = $this->manufacturerRepository->findAll();

        $this->view->assignMultiple([
            'feUser' => $feUser,
            'productsCount' => is_array($products) ? count($products) : $products->count(),
            'categoriesCount' => is_array($categories) ? count($categories) : $categories->count(),
            'manufacturersCount' => is_array($manufacturers) ? count($manufacturers) : $manufacturers->count(),
        ]);

        return $this->htmlResponse();
    }

    // ============= PRODUKTE =============

    public function listProductsAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $products = $this->productRepository->findAll();
        $productsArray = is_array($products) ? $products : $products->toArray();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'products' => $productsArray,
        ]);

        return $this->htmlResponse();
    }

    public function editProductAction(Product $product = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $categories = $this->categoryRepository->findAll();
        $manufacturers = $this->manufacturerRepository->findAll();
        
        // Get selected category UIDs for template
        $selectedCategoryUids = [];
        if ($product) {
            $productCategories = $product->getCategories();
            if ($productCategories) {
                foreach ($productCategories as $cat) {
                    $selectedCategoryUids[$cat->getUid()] = true;
                }
            }
        }
        
        // Add isSelected flag to each category
        $categoriesArray = is_array($categories) ? $categories : $categories->toArray();
        $enrichedCategories = [];
        foreach ($categoriesArray as $cat) {
            $enrichedCategories[] = [
                'uid' => $cat->getUid(),
                'title' => $cat->getTitle(),
                'isSelected' => isset($selectedCategoryUids[$cat->getUid()]),
            ];
        }

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'product' => $product,
            'categories' => $enrichedCategories,
            'manufacturers' => is_array($manufacturers) ? $manufacturers : $manufacturers->toArray(),
        ]);

        return $this->htmlResponse();
    }

    public function newProductAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $categories = $this->categoryRepository->findAll();
        $manufacturers = $this->manufacturerRepository->findAll();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'product' => null,
            'categories' => is_array($categories) ? $categories : $categories->toArray(),
            'manufacturers' => is_array($manufacturers) ? $manufacturers : $manufacturers->toArray(),
        ]);

        return $this->htmlResponse();
    }

    public function saveProductAction(Product $product = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $data = $this->request->getParsedBody();

            if ($product === null) {
                $product = new Product();
                $product->setPid((int)$this->request->getAttribute('site')->getRootPageId());
            }

            $product->setTitle((string)($data['title'] ?? ''));
            $product->setSku((string)($data['sku'] ?? ''));
            $product->setPrice((float)($data['price'] ?? 0));
            $product->setSpecialPrice((float)($data['special_price'] ?? 0));
            $product->setDescription((string)($data['description'] ?? ''));
            $product->setShortDescription((string)($data['short_description'] ?? ''));
            $product->setHeadline((string)($data['headline'] ?? ''));
            $product->setStock((int)($data['stock'] ?? 0));
            $product->setWeight((float)($data['weight'] ?? 0));
            $product->setIsActive((bool)($data['is_active'] ?? true));
            $product->setShippingFree((bool)($data['shipping_free'] ?? false));

            // Manufacturer
            if (!empty($data['manufacturer'])) {
                $manufacturer = $this->manufacturerRepository->findByUid((int)$data['manufacturer']);
                if ($manufacturer) {
                    $product->setManufacturer($manufacturer);
                }
            }

            // Categories
            if (!empty($data['categories']) && is_array($data['categories'])) {
                $categories = $this->categoryRepository->findAll();
                $categoriesArray = is_array($categories) ? $categories : $categories->toArray();
                $categoryMap = array_combine(
                    array_map(fn($c) => $c->getUid(), $categoriesArray),
                    $categoriesArray
                );

                $product->getCategories()->removeAll($product->getCategories());
                foreach ($data['categories'] as $catId) {
                    if (isset($categoryMap[(int)$catId])) {
                        $product->addCategory($categoryMap[(int)$catId]);
                    }
                }
            }

            if ($product->getUid() === null) {
                $this->productRepository->add($product);
            } else {
                $this->productRepository->update($product);
            }

            $this->addFlashMessage('Produkt erfolgreich gespeichert.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
            return $this->redirect('listProducts');
        } catch (\Exception $e) {
            $this->logger->error('Error saving product: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Speichern des Produkts.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            return $this->redirect('listProducts');
        }
    }

    public function deleteProductAction(Product $product): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $this->productRepository->remove($product);
            $this->addFlashMessage('Produkt erfolgreich gelöscht.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        } catch (\Exception $e) {
            $this->logger->error('Error deleting product: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Löschen des Produkts.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
        }

        return $this->redirect('listProducts');
    }

    // ============= KATEGORIEN =============

    public function listCategoriesAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $categories = $this->categoryRepository->findAll();
        $categoriesArray = is_array($categories) ? $categories : $categories->toArray();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'categories' => $categoriesArray,
        ]);

        return $this->htmlResponse();
    }

    public function editCategoryAction(Category $category = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $categories = $this->categoryRepository->findAll();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'category' => $category,
            'allCategories' => is_array($categories) ? $categories : $categories->toArray(),
        ]);

        return $this->htmlResponse();
    }

    public function newCategoryAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $categories = $this->categoryRepository->findAll();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'category' => null,
            'allCategories' => is_array($categories) ? $categories : $categories->toArray(),
        ]);

        return $this->htmlResponse();
    }

    public function saveCategoryAction(Category $category = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $data = $this->request->getParsedBody();

            if ($category === null) {
                $category = new Category();
                $category->setPid((int)$this->request->getAttribute('site')->getRootPageId());
            }

            $category->setTitle((string)($data['title'] ?? ''));
            $category->setDescription((string)($data['description'] ?? ''));

            // Parent category
            if (!empty($data['parent'])) {
                $parent = $this->categoryRepository->findByUid((int)$data['parent']);
                if ($parent) {
                    $category->setParent($parent);
                }
            }

            if ($category->getUid() === null) {
                $this->categoryRepository->add($category);
            } else {
                $this->categoryRepository->update($category);
            }

            $this->addFlashMessage('Kategorie erfolgreich gespeichert.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
            return $this->redirect('listCategories');
        } catch (\Exception $e) {
            $this->logger->error('Error saving category: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Speichern der Kategorie.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            return $this->redirect('listCategories');
        }
    }

    public function deleteCategoryAction(Category $category): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $this->categoryRepository->remove($category);
            $this->addFlashMessage('Kategorie erfolgreich gelöscht.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        } catch (\Exception $e) {
            $this->logger->error('Error deleting category: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Löschen der Kategorie.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
        }

        return $this->redirect('listCategories');
    }

    // ============= HERSTELLER =============

    public function listManufacturersAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $manufacturers = $this->manufacturerRepository->findAll();
        $manufacturersArray = is_array($manufacturers) ? $manufacturers : $manufacturers->toArray();

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'manufacturers' => $manufacturersArray,
        ]);

        return $this->htmlResponse();
    }

    public function editManufacturerAction(Manufacturer $manufacturer = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'manufacturer' => $manufacturer,
        ]);

        return $this->htmlResponse();
    }

    public function newManufacturerAction(): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        $this->view->assignMultiple([
            'feUser' => $this->getCurrentFrontendUser(),
            'manufacturer' => null,
        ]);

        return $this->htmlResponse();
    }

    public function saveManufacturerAction(Manufacturer $manufacturer = null): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $data = $this->request->getParsedBody();

            if ($manufacturer === null) {
                $manufacturer = new Manufacturer();
                $manufacturer->setPid((int)$this->request->getAttribute('site')->getRootPageId());
            }

            $manufacturer->setTitle((string)($data['title'] ?? ''));
            $manufacturer->setDescription((string)($data['description'] ?? ''));
            $manufacturer->setWebsite((string)($data['website'] ?? ''));

            if ($manufacturer->getUid() === null) {
                $this->manufacturerRepository->add($manufacturer);
            } else {
                $this->manufacturerRepository->update($manufacturer);
            }

            $this->addFlashMessage('Hersteller erfolgreich gespeichert.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
            return $this->redirect('listManufacturers');
        } catch (\Exception $e) {
            $this->logger->error('Error saving manufacturer: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Speichern des Herstellers.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            return $this->redirect('listManufacturers');
        }
    }

    public function deleteManufacturerAction(Manufacturer $manufacturer): ResponseInterface
    {
        if (!$this->requireAuth()) {
            return $this->redirect('dashboard');
        }

        try {
            $this->manufacturerRepository->remove($manufacturer);
            $this->addFlashMessage('Hersteller erfolgreich gelöscht.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        } catch (\Exception $e) {
            $this->logger->error('Error deleting manufacturer: ' . $e->getMessage());
            $this->addFlashMessage('Fehler beim Löschen des Herstellers.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
        }

        return $this->redirect('listManufacturers');
    }

    // ============= HELPER =============

    protected function getCurrentFrontendUser()
    {
        try {
            $userId = $this->context->getPropertyFromAspect('frontend.user', 'id');
            return $userId ? ['uid' => $userId] : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
