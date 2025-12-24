<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Api;

use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Psr\Log\LoggerInterface;

/**
 * @Api\Endpoint()
 */
class Product extends AbstractApi
{
    public function __construct(
        readonly private ProductRepository $productRepository,
        readonly private LoggerInterface $logger
    ) {
    }

    /**
     * ## Alle Produkte abrufen
     *
     * Ruft alle Produkte aus der Datenbank ab.
     *
     * ### Beispiel
     *
     * ```
     * GET /api/product/all
     * ```
     *
     * ### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "title": "Chiptuning ECU",
     *       "sku": "CT-ECU-001",
     *       "price": 299.99,
     *       "specialPrice": 249.99,
     *       "description": "Professionelles Chiptuning...",
     *       "stock": 50,
     *       "isActive": true
     *     }
     *   ],
     *   "count": 1
     * }
     * ```
     *
     * @Api\Access("public")
     * @return array
     */
     public function allAction(): array
     {
         try {
             $products = $this->productRepository->findAllIgnoreStorage();
             return [
                 'success' => true,
                 'data' => $products,
                 'count' => $products->count(),
             ];
         } catch (\Exception $e) {
             $this->logger->error('Error fetching products', ['exception' => $e->getMessage()]);
             return [
                 'success' => false,
                 'message' => 'Error fetching products',
             ];
         }
     }

     /**
      * ## Alias für alle Produkte
      *
      * Alias für allAction()
      *
      * @Api\Route("/product/all")
      * @Api\Access("public")
      * @return array
      */
     public function getAllAction(): array
     {
         return $this->allAction();
     }

    /**
     * ## Einzelnes Produkt abrufen
     *
     * Ruft ein einzelnes Produkt nach seiner UID ab.
     *
     * ### Beispiel
     *
     * ```
     * GET /api/product/1
     * ```
     *
     * ### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": {
     *     "uid": 1,
     *     "title": "Chiptuning ECU",
     *     "sku": "CT-ECU-001",
     *     "price": 299.99
     *   }
     * }
     * ```
     *
     * @Api\Access("public")
     * @return array
     */
    public function getIndexAction(): array
    {
        try {
            // Get UID from request arguments (nnrestapi passes it as uid parameter)
            $args = $this->request->getArguments();
            $uid = (int)($args['uid'] ?? 0);

            if ($uid === 0) {
                return [
                    'success' => false,
                    'message' => 'Product UID required',
                ];
            }

            $product = $this->productRepository->findByUidIgnoreStorage($uid);

            if ($product === null) {
                return [
                    'success' => false,
                    'message' => 'Product not found',
                ];
            }

            return [
                'success' => true,
                'data' => $product,
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching product', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching product',
            ];
        }
    }

    /**
     * ## Nach Suchbegriff suchen
     *
     * Sucht nach Produkten basierend auf einem Suchterm.
     * Die Suche erfolgt in den Feldern: Titel, Beschreibung, SKU.
     *
     * ### Parameter
     *
     * - **term** (erforderlich): Der Suchbegriff
     *
     * ### Beispiele
     *
     * #### Chiptuning Produkte suchen
     *
     * ```
     * GET /api/product/search?term=chiptuning
     * ```
     *
     * #### Respons
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "title": "Chiptuning ECU",
     *       "sku": "CT-ECU-001",
     *       "price": 299.99
     *     }
     *   ],
     *   "count": 1
     * }
     * ```
     *
     * @Api\Route("/product/search")
     * @Api\Access("public")
     * @return array
     */
    public function getSearchAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $term = $args['term'] ?? '';

            if (empty($term)) {
                return [
                    'success' => false,
                    'message' => 'Search term required',
                ];
            }

            $products = $this->productRepository->searchByTerm($term);

            return [
                'success' => true,
                'data' => $products,
                'count' => $products->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error searching products', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error searching products',
            ];
        }
    }

    /**
     * ## Nur aktive Produkte
     *
     * Ruft nur aktive Produkte ab.
     *
     * ### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [...],
     *   "count": 25
     * }
     * ```
     *
     * @Api\Route("/product/active")
     * @Api\Access("public")
     * @return array
     */
    public function getActiveAction(): array
    {
        try {
            $products = $this->productRepository->findActive();

            return [
                'success' => true,
                'data' => $products,
                'count' => $products->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching active products', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching active products',
            ];
        }
    }

    /**
     * ## Neueste Produkte
     *
     * Ruft die neuesten Produkte ab.
     *
     * ### Parameter
     *
     * - **limit** (optional): Anzahl der Produkte (default: 10)
     *
     * ### Beispiele
     *
     * #### 5 neueste Produkte
     *
     * ```
     * GET /api/product/recent?limit=5
     * ```
     *
     * @Api\Route("/product/recent")
     * @Api\Access("public")
     * @return array
     */
    public function getRecentAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $limit = (int)($args['limit'] ?? 10);

            $products = $this->productRepository->findRecent($limit);

            return [
                'success' => true,
                'data' => $products,
                'count' => $products->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching recent products', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching recent products',
            ];
        }
    }

    /**
     * ## Produkt nach SKU-Nummer
     *
     * Sucht ein Produkt nach seiner SKU-Nummer (Artikel-Nummer).
     *
     * ### Parameter
     *
     * - **sku** (erforderlich): Die SKU-Nummer des Produkts
     *
     * ### Beispiele
     *
     * #### Produkt mit SKU ABC123
     *
     * ```
     * GET /api/product/sku?sku=ABC123
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": {
     *     "uid": 1,
     *     "sku": "ABC123",
     *     "title": "Chiptuning ECU",
     *     "price": 299.99
     *   }
     * }
     * ```
     *
     * ### Fehler
     *
     * Wenn die SKU nicht gefunden wird:
     *
     * ```json
     * {
     *   "success": false,
     *   "message": "Product with this SKU not found"
     * }
     * ```
     *
     * @Api\Route("/product/sku")
     * @Api\Access("public")
     * @return array
     */
    public function getSkuAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $sku = $args['sku'] ?? '';

            if (empty($sku)) {
                return [
                    'success' => false,
                    'message' => 'SKU required',
                ];
            }

            $query = $this->productRepository->createQuery();
            $query->matching($query->equals('sku', $sku));
            $product = $query->execute()->getFirst();

            if ($product === null) {
                return [
                    'success' => false,
                    'message' => 'Product with this SKU not found',
                ];
            }

            return [
                'success' => true,
                'data' => $product,
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching product by SKU', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching product',
            ];
        }
    }
}
